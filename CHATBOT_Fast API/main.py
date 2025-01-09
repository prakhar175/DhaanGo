from fastapi import FastAPI, HTTPException
from fastapi.responses import HTMLResponse
from pydantic import BaseModel
from fastapi.staticfiles import StaticFiles
import requests
from groq import Groq

GROQ_API_KEY = "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"
DEVNAGRI_API_KEY = "devnagri_56871d5c8e5111efa1ce4a279c6d377c"
DEVNAGRI_URL = 'https://api.devnagri.com/machine-translation/v2/translate'

app = FastAPI()

client = Groq(api_key=GROQ_API_KEY)

class RequestData(BaseModel):
    input_text: str

@app.get("/", response_class=HTMLResponse)
async def read_index():
    with open("templates/index.html") as f:
        return f.read()

@app.post("/test-groq/")
async def test_groq(data: RequestData):
    try:
        chat_completion = client.chat.completions.create(
            messages=[{"role": "user", "content": f"for the given crop {data.input_text}, please give the type of fertilizer and pesticides to be used for best yield.Give output should be under 100 words and no heading or subheading"}],
            model="llama3-8b-8192",
        )
        return {"groq_response": chat_completion.choices[0].message.content}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Groq API error: {str(e)}")

@app.post("/test-translation/")
async def test_translation():
    try:
        test_text = "This is a test sentence."
        translation_data = {
            'key': DEVNAGRI_API_KEY,
            'sentence': test_text,
            'src_lang': 'en',
            'dest_lang': 'hi'
        }
        
        response = requests.post(DEVNAGRI_URL, data=translation_data)
        if response.status_code != 200:
            return {"error": f"Translation API returned status code {response.status_code}", "response": response.text}
        
        return {"translation_response": response.json()}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Translation API error: {str(e)}")

@app.post("/generate/")
async def generate_text(data: RequestData):
    try:
        # Fetch fertilizer and pesticide recommendations
        chat_completion = client.chat.completions.create(
            messages=[{"role": "user", "content": f"for the given crop {data.input_text}, please give the type of fertilizer and pesticides to be used for best yield.Give output should be under 100 words and no heading or subheading"}],
            model="llama3-8b-8192",
        )
        
        help = chat_completion.choices[0].message.content
        print(f"Groq response: {help}")  # Debug print
        
        # Translate the response
        translation_data = {
            'key': DEVNAGRI_API_KEY,
            'sentence': help,
            'src_lang': 'en',
            'dest_lang': 'hi'
        }
        
        response = requests.post(DEVNAGRI_URL, data=translation_data)
        print(f"Translation API response status: {response.status_code}")  # Debug print
        print(f"Translation API response: {response.text}")  # Debug print
        
        if response.status_code != 200:
            raise HTTPException(status_code=response.status_code, 
                              detail=f"Translation API error: {response.text}")
        
        ans = response.json()
        answer = ans.get("translated_text")
        if not answer:
            raise HTTPException(status_code=500, 
                              detail=f"No translated text in response: {ans}")

        return {"generated_text": answer}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)