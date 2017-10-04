# Using the Appzio translation engine

In order to make sure that your application is fully translatable, please write all the strings in the php code with the following notation:
`{#my_translation_string#}`. This string will automatically get converted to `My translation string` and is automatically added to the translation tool.

#### Working with strings

Strings are accessible from the web dashboard and can be exported to .csv file and then re-imported. Appzio can also automatically translate your strings using Google Translate to any target language supported by Google. This way you can get a rough translation of your application to different languages. 

#### Character support

All string content is utf-16 by default, so your content supports right to left and emojis.

#### Adding language support for your app

All supported languages are defined in the web control panel and there is an action for choosing the language. This can be easily added to your application without any modifications.

#### Note about adding a new language

When adding a new language, client might show strings initially in English. This is due to possible delay on translating the string on the fly. Once the strings are added and visible in the translation manager, the app will work normally with the new language.