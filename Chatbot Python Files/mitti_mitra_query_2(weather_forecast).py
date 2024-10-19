
#
#!pip install elevenlabs
#!pip install pygame sounddevice soundfile

import requests
from datetime import datetime

API_KEY = 'koRm4O8n7QEoH6BopQSVPY9OtySOYiZD'

latitude = 26.2124 #input from SQL
longitude = 78.1772 #input from SQL


url = f'https://api.tomorrow.io/v4/timelines?location={latitude},{longitude}&fields=temperature,precipitationProbability&timesteps=1h&units=metric&apikey={API_KEY}'

response = requests.get(url)

if response.status_code == 200:
    data = response.json()
    daily_summary = {}


    for timestep in data['data']['timelines'][0]['intervals']:
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

import os

from groq import Groq

client = Groq(
    api_key="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",
)

chat_completion = client.chat.completions.create(
    messages=[
        {
            "role": "user",
            "content": f"Given the dictionary {daily_summary} with dates, the max , min temp and precipitation of the date, write a proper statement to summarize it, and this data is a future prediction of the next 5 daya for weather forecast for farmers,frame the statement in such ways only, the numbers should be specified only the highest and lowest of the whole 5 days and the precipiation amount. Give only plain text without any headings or subheadings. Give the answer in less than 150 words.",
        }
    ],
    model="llama3-8b-8192",
)

Hindi_Text = chat_completion.choices[0].message.content

url = 'https://api.devnagri.com/machine-translation/v2/translate'

data = {
    'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',  
    'sentence': Hindi_Text,
    'src_lang': 'en',
    'dest_lang': 'hi'
}


response = requests.post(url, data=data)

ans = response.json()
answer = ans["translated_text"]

print(Hindi_Text)
print(answer)

import requests
import io
import pygame
import time
from pygame import mixer
import tempfile
import os
import sounddevice as sd
import soundfile as sf
import numpy as np

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
        print("Converting text to speech...")
        response = requests.post(url, json=data, headers=headers)

        if response.status_code == 200:
            print("✓ Conversion successful!")
            return response.content
        else:
            print(f"✗ Error: {response.status_code}")
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
        pygame.mixer.quit()
        os.remove(temp_audio_path)

    except Exception as e:
        print(f"Error playing audio: {str(e)}")


def main():

    hindi_text = answer

    audio_data = text_to_speech_direct(hindi_text)

    if audio_data:
        print("\nPlaying audio using pygame...")
        play_audio_pygame(audio_data)


if __name__ == "__main__":
    main()





