
GROQ_API_KEY="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"

import os
import requests
from groq import Groq
import requests
import io
import pygame
import time
from pygame import mixer
import tempfile
import sounddevice as sd
import soundfile as sf
import numpy as np

def add_memory(memory, temp_content ):
    client = Groq(
        api_key=GROQ_API_KEY,
    )
    Query = temp_content
    chat_completion = client.chat.completions.create(
        messages=[
            {
                "role": "user",
                "content": f"Please Summarise this into less than 100 words {Query}, only highlight the main points, and especially numbers.",
            }
            ],
            model="llama3-8b-8192",
        )

    memory.append(chat_completion.choices[0].message.content)

url = 'https://api.devnagri.com/machine-translation/v2/translate'
def hindi_translator(temp_content):
    data = {
        'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',
        'sentence': temp_content,
        'src_lang': 'en',
        'dest_lang': 'hi'
        }
    response = requests.post(url, data=data)
    ans = response.json()
    answer = ans["translated_text"]
    return answer

def audio_converter(answer):
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

memory = []
Help =0
a=0
while Help == 0:
    client = Groq(
        api_key=GROQ_API_KEY,
    )

    if a ==0:
        Query = input("अपनी समस्याएँ बताएं ")
        url = 'https://api.devnagri.com/machine-translation/v2/translate'

        # Form data
        data = {
            'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c', 
            'sentence': Query,
            'src_lang': 'hi',
            'dest_lang': 'en'
        }

        # Make POST request
        response = requests.post(url, data=data)

        ans = response.json()
        answer = ans["translated_text"]
        Query = answer
        a+=1
        chat_completion = client.chat.completions.create(
            messages=[
                {
                    "role": "user",
                    "content": f"You are an agrilogist from India , without specifying you are an agrilogist, you have all the knowledge in farming in india, please give the answer to the query {Query}, i am a farmer so give the answer which can be very easy to understand, give a concise and short answer. The output should only include details about agriculture and farming in india. give the answer without any headings or subheadings, just plain text. Give the answer in less than 150 words.",
                }
            ],
                model="llama3-8b-8192",
        )
    else:
        Query = input("अपनी समस्याएँ बताएं ")
        url = 'https://api.devnagri.com/machine-translation/v2/translate'

        # Form data
        data = {
            'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c', 
            'sentence': Query,
            'src_lang': 'hi',
            'dest_lang': 'en'
        }

        # Make POST request
        response = requests.post(url, data=data)

        ans = response.json()
        answer = ans["translated_text"]
        Query = answer
        chat_completion = client.chat.completions.create(
            messages=[
                {
                    "role": "user",
                    "content": f"You are an agrilogist from India, without specifying you are an agrilogist ,you have all the knowledge in farming in India , please give the answer to the query {Query},also use the given {memory}, this is a collection of all the important parts from your previous chat, use this data to integrate a better solution. i am a farmer so give the answer which can be very easy to understand, keep the topics within the agricultural field, give a concise and short answer. The output should only include details about agriculture and farming in india. give the answer without any headings or subheadings, just plain text. Give the answer in less than 150 words.",
                }
            ],
                model="llama3-8b-8192",
        )

    temp_content = chat_completion.choices[0].message.content
    add_memory (memory, temp_content)

    answer = hindi_translator(temp_content)

    print(temp_content)
    print(answer)

    audio_converter(answer)

    Help = int(input("0/1"))