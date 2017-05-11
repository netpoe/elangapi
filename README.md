# Can computers create their own opinions?

ELang is a library of world languages arranged by 

- Language codes. e.g. es_MX
- Parts of speech structured alphabetically

In the future, ELang should be able to parse content and: 

- Fix grammar mistakes
- Fix typos
- Get the context of what's written
- Answer questions like: who, when, where, what
- Get similarities between different blocks of content
- Be able to generate human-like conclusions from the parsed content such as: _Ben is trying to fix his code and he is requesting Elaine's help_ (in all languages)

# Roadmap

It would be great to have a robust API where the endpoints work something like this:

```
GET //elang.something/{language_code}/verbs?l=a,f,t

GET //elang.something/{language_code}/verbs?conjugate=dance

GET //elang.something/{language_code}/verbs?toPast=code

GET //elang.something/{language_code}/nouns?similarTo=keyboard

GET //elang.something/{language_code}/content?get=verbs

GET //elang.something/{language_code}/content?get=sentences

GET //elang.something/{language_code}/content?who=1&when=1
```