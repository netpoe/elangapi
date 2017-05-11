# Can computers create their own opinions?

ELang is a library of world languages arranged by 

- Language codes. e.g. es_MX
- Parts of speech structured alphabetically

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