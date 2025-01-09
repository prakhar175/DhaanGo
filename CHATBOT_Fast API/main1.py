from fastapi import FastAPI, Query
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates
from fastapi.requests import Request
import requests
import os
import tempfile
import pygame
import time
from groq import Groq

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Adjust this as necessary for your frontend
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.mount("/static", StaticFiles(directory="static"), name="static")

# Ensure the directory name matches your actual folder structure
templates = Jinja2Templates(directory="templates")  # Adjusted if necessary

# Groq API key for chatbot interactions
GROQ_API_KEY = "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"
client = Groq(api_key=GROQ_API_KEY)

# Weather API Key
WEATHER_API_KEY = 'koRm4O8n7QEoH6BopQSVPY9OtySOYiZD'

@app.get("/")
async def root():
    return {"message": "Welcome to the Weather Forecast Chatbot!"}

# New route for rendering index1.html
@app.get("/index1/")
async def render_index1(request: Request):
    return templates.TemplateResponse("index1.html", {"request": request})

@app.get("/weather_forecast/")
async def weather_forecast_endpoint(latitude: float = Query(...), longitude: float = Query(...)):
    url = f'https://api.tomorrow.io/v4/timelines?location={latitude},{longitude}&fields=temperature,precipitationProbability&timesteps=1h&units=metric&apikey={WEATHER_API_KEY}'
    response = requests.get(url)
    
    if response.status_code == 200:
        data = response.json()
        daily_summary = {}

        for timestep in data.get('data', {}).get('timelines', [{}])[0].get('intervals', []):
            timestamp = timestep['startTime']
            temperature = timestep['values']['temperature']
            precipitation = timestep['values']['precipitationProbability']

            date = timestamp.split('T')[0]

            if date not in daily_summary:
                daily_summary[date] = {
                    'max_temp': temperature,
                    'min_temp': temperature,
                    'total_precipitation': precipitation
                }
            else:
                if temperature > daily_summary[date]['max_temp']:
                    daily_summary[date]['max_temp'] = temperature
                if temperature < daily_summary[date]['min_temp']:
                    daily_summary[date]['min_temp'] = temperature
                daily_summary[date]['total_precipitation'] += precipitation

        # Summarize weather data using Groq API
        chat_completion = client.chat.completions.create(
            messages=[{
                "role": "user",
                "content": f"Given the dictionary {daily_summary} with dates, max and min temperatures, and precipitation, summarize the weather forecast for the next 5 days. Frame it as advice for farmers."
            }],
            model="llama3-8b-8192"
        )
        response_text = chat_completion.choices[0].message.content

        return JSONResponse(content={"forecast_summary": response_text})
    else:
        return JSONResponse(content={"error": "Unable to retrieve weather data."}, status_code=500)

def convert_text_to_speech(text: str) -> str:
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
    response = requests.post(url, json=data, headers=headers)
    if response.status_code == 200:
        temp_audio_path = tempfile.mktemp(suffix='.mp3')
        with open(temp_audio_path, 'wb') as audio_file:
            audio_file.write(response.content)
        return temp_audio_path
    else:
        print(f"Error in audio conversion: {response.status_code}")
        return ""

def play_audio_pygame(audio_path: str):
    pygame.mixer.init()
    pygame.mixer.music.load(audio_path)
    pygame.mixer.music.play()
    while pygame.mixer.music.get_busy():
        time.sleep(0.1)
    pygame.mixer.quit()
    os.remove(audio_path)  # Remove audio after playing

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)
