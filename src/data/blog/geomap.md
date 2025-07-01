---
slug: jak-ai-pomaga-w-nowych-zadaniach

meta:
  title: Jak AI rozwiązuje problemy - mapy w 3D
  description: Zobacz, jak sztuczna inteligencja pomogła mi zrealizować zadanie, z którym nie miałem doświadczenia.
heading: Sztuczna inteligencja w akcji - jak AI pomogło mi ogarnąć temat map
leading: Ostatnio spróbowałem podjąć się zadania, które było dla mnie zupełną nowością. Postanowiłem wykorzystać sztuczną inteligencję jako mojego osobistego przewodnika i asystenta. Okazało się, że to strzał w dziesiątkę.
subheading: Nowe wyzwanie, nieznany temat. Czas na AI
image:
  alt: ai jako wsparcie w nowych zadaniach
  src: geomap.webp
categories:
  - automatyzacja
date: 2025-07-01
video: https://www.youtube.com/embed/vZJmNCbSGzM?si=sEoWzEJn68SV2_gL
draft: false
---

## Zlecenie na platformie useme

Wszystko zaczęło się od zlecenia na platformie useme. Ktoś szukał kogoś, kto potrafi szybko wyeksportować cały powiat z map google do wektora, najlepiej z budynkami 3D.

Nigdy wcześniej nie zajmowałem się mapami, ale pomyślałem, że spróbuję. Wiedziałem, że sam nie dam rady, będę musiał szukać informacji, ale tym razem nie w Google, ale z AI.

## AI jako osobisty asystent

Zacząłem od tego, że wkleiłem całe zlecenie do Gemini. Zapytałem, czy da się to łatwo zrobić, a także zasugerowałem alternatywne rozwiązanie w postaci OpenStreetMap, o którym gdzieś słyszałem. Odpowiedź była natychmiastowa.

Gemini jasno wyjaśniło, że eksport z map Google jest niemożliwy z powodu problemów licencyjnych i technicznych. Jednak od razu wskazało na OpenStreetMap jako idealną alternatywę i wymieniło konkretne narzędzia, które mi pomogą: Geofabrik i QGIS. Podało też precyzyjną instrukcję krok po kroku.

## Praktyczne zastosowanie wiedzy z AI

Zgodnie z instrukcjami, wszedłem na stronę Geofabrik, pobrałem dane dla województwa i zainstalowałem QGIS. AI pokierowało mnie przez proces importu danych i obcinania mapy do rozmiaru powiatu.

Najbardziej fascynujące było jednak to, jak AI pomogło mi z detalami. Zauważyłem, że w danych brakuje informacji o wysokości budynków. Zapytałem o to Gemini, a ono podpowiedziało, że informacja o liczbie pięter (building:levels) może znajdować się w „ukrytych” tagach. Co więcej, AI zasugerowało, że można napisać prostą funkcję, która wyodrębni tę wartość i stworzy z niej nowy atrybut! Dzięki temu mogłem stworzyć wizualizację budynków w 3D, mnożąc liczbę pięter przez 3 metry.

## Wnioski: Potęga AI w nowej dziedzinie

Ten eksperyment pokazał, jak AI może przyspieszyć naukę i rozwiązywanie problemów w nowych, niszowych dziedzinach. Zamiast spędzać godziny na szukaniu informacji w internecie i testowaniu różnych rozwiązań, po prostu komunikowałem się z asystentem AI.

Oczywiście, nie obyło się bez wyzwań. Czasami pojawiały się błędy, a ja musiałem wykazać się pewną "techniczną intuicją". Mimo to, uważam, że sztuczna inteligencja jest niesamowicie pomocna, zwłaszcza gdy potrzebujesz szybkiego wprowadzenia do nowego tematu.
