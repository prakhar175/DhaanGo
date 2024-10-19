GROQ_API_KEY="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"

url = 'https://api.devnagri.com/machine-translation/v2/translate'

import os
import requests
from groq import Groq

memory=[]

a = 0
b=0

client = Groq(
api_key=GROQ_API_KEY,
)

Query = input("आप जिस फसल के लिए खाद और कीटनाशक ढूंढना चाहते हैं, उसे दें के लिए ")
chat_completion = client.chat.completions.create(
messages=[
{
"role": "user",
"content": f"for the given crop {Query},please give the type of fertilizer and pesticides to be used for best yield, showing the composition. Also tell the user to refer to our marketplace for further optionsof fertilizer according to the composition. give the answer without any headings or subheadings, just plain text",
}
],
model="llama3-8b-8192",
        )


help=chat_completion.choices[0].message.content
print(help)
data = {
'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',
'sentence': help,
'src_lang': 'en',
'dest_lang': 'hi'
}

response = requests.post(url, data=data)

ans = response.json()
answer = ans["translated_text"]
print(answer)

