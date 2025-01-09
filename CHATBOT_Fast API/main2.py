import os
import requests
from groq import Groq
from fastapi import FastAPI, HTTPException
from fastapi.responses import HTMLResponse, JSONResponse
from pydantic import BaseModel
import pygame
import tempfile
import time

# Set up your API key and other constants
GROQ_API_KEY = "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"
DEVNAGRI_API_KEY = "devnagri_56871d5c8e5111efa1ce4a279c6d377c"
DEVNAGRI_URL = 'https://api.devnagri.com/machine-translation/v2/translate'

app = FastAPI()
client = Groq(api_key=GROQ_API_KEY)

class RequestData(BaseModel):
    query: str

@app.get("/", response_class=HTMLResponse)
async def read_index():
    try:
        with open("templates/index2.html", encoding='utf-8') as f:
            return f.read()
    except FileNotFoundError:
        raise HTTPException(status_code=404, detail="HTML file not found.")
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

# Memory to store past answers
memory = []

def add_memory(memory, temp_content):
    chat_completion = client.chat.completions.create(
        messages=[{
            "role": "user",
            "content": f"Please Summarise this into less than 80 words {temp_content}, just give me plain text not highlighted. "
        }],
        model="llama3-8b-8192",
    )
    memory.append(chat_completion.choices[0].message.content)

def hindi_translator(temp_content):
    data = {
        'key': DEVNAGRI_API_KEY,
        'sentence': temp_content,
        'src_lang': 'en',
        'dest_lang': 'hi'
    }
    response = requests.post(DEVNAGRI_URL, data=data)  # Fixed: Use DEVNAGRI_URL instead of undefined url
    ans = response.json()
    answer = ans["translated_text"]
    return answer

def text_to_speech_direct(text):
    API_KEY = "sk_960d5837e76361493bce03b2d3ad9f5dcde11abe20ca69b3"
    VOICE_ID = "21m00Tcm4TlvDq8ikWAM"

    url = f"https://api.elevenlabs.io/v1/text-to-speech/{VOICE_ID}"

    headers = {
        "Accept": "audio/mpeg",
        "Content-Type": "application/json",
        "xi-api-key": API_KEY
    }

    data = {
        "text": text,
        "model_id": "eleven_multilingual_v2",
        "voice_settings": {
            "stability": 1.0,
            "similarity_boost": 0.75
        }
    }

    try:
        response = requests.post(url, json=data, headers=headers)
        if response.status_code == 200:
            return response.content
        else:
            print(f"✗ Error: {response.status_code} - {response.text}")
            return None
    except Exception as e:
        print(f"✗ An error occurred: {str(e)}")
        return None

def play_audio_pygame(audio_data):
    try:
        pygame.mixer.init()
        with tempfile.NamedTemporaryFile(delete=False, suffix='.mp3') as temp_audio:
            temp_audio.write(audio_data)
            temp_audio_path = temp_audio.name

        pygame.mixer.music.load(temp_audio_path)
        pygame.mixer.music.play()

        while pygame.mixer.music.get_busy():
            time.sleep(0.1)

        pygame.mixer.music.stop()
        os.remove(temp_audio_path)

    except Exception as e:
        print(f"Error playing audio: {str(e)}")

@app.post("/ask/", response_class=JSONResponse)
async def ask_farming_advice(data: RequestData):
    try:
        # Translate the query from Hindi to English
        translation_data = {
            'key': DEVNAGRI_API_KEY,
            'sentence': data.query,
            'src_lang': 'hi',
            'dest_lang': 'en'
        }
        response = requests.post(DEVNAGRI_URL, data=translation_data)
        translated_query = response.json().get("translated_text", "Translation failed.")

        # Fetch farming advice
        chat_completion = client.chat.completions.create(
            messages=[{
                "role": "user",
                "content": f"You are an agrilogist from India, please give the answer to the query: {translated_query}, dont give heading or subheading just plain text that too maximum of 500 words alse dont write as an agrologist."
            }],
            model="llama3-8b-8192",
        )

        temp_content = chat_completion.choices[0].message.content
        add_memory(memory, temp_content)

        # Convert response to Hindi
        hindi_response = hindi_translator(temp_content)

        # Convert Hindi response to audio
        audio_data = text_to_speech_direct(hindi_response)
        if audio_data:
            play_audio_pygame(audio_data)

        return {"response": temp_content, "hindi_response": hindi_response}

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)
