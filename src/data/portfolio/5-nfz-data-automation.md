---
slug: automatyczne-uzyskanie-danych-z-internetu
order: 7
meta:
  title: Automatyczne uzyskanie danych z internetu
  description: Automatyczne pobieranie danych z internetu za pomocą Python, requests i BeautifulSoup – 36 000 rekordów w 5 godzin pracy
title: Automatyczne uzyskanie danych z internetu bez API, czyli jak uratowałem klienta i zaoszczędziłem mu ponad 100 godzin pracy
problem: Ogromna ilość pracy, by pozyskać tę ilość danych przy bardzo małej ilości czasu
target: Zautomatyzowanie procesu pobierania i dopasowania oraz utworzenie pliku wynikowego i uratowanie zlecenia klienta
result: Uratowanie zlecenia klienta, uzyskanych ponad 36 000 rekordów i oszczędność nawet 100 godzin pracy
image:
  alt: Automatyzacja pobierania danych z internetu bez API
  src: portfolio/nfz-data-automation.webp
category: automatyzacja
videos:
  - https://www.youtube.com/embed/2IXd7NWB7iA?si=dm04M75lVDl3qAKP
draft: false
---

## Geneza projektu

Projekt zrealizowany w sierpniu 2024 roku, w ciągu kilku godzin. Na pewnym forum informatycznym pojawił się tajemniczy post od kogoś, kto poszukiwał pilnie programisty do wykonania programu. Temat był niejasny. Zgłosiłem się, napisałem e-maila, później rozmawialiśmy telefonicznie.

## Problem

Problem dotyczył tego, że ta osoba zobowiązała się do przygotowania listy placówek NFZ (świadczeniodawców). Sęk w tym, że tych danych było naprawdę sporo, a czasu niewiele. Brawo za pomysł automatyzacji, bo bez tego (działanie manualne) byłoby ciężko.

## Cel

Ostatecznie okazało się, że celem nie był skrypt, program graficzny, czy aplikacja, ale same dane w formacie CSV. Należało zatem w sposób automatyczny pobrać i ustrukturyzować całkiem sporą liczbę danych.

## Realizacja

### Skąd te dane?

Dane są dostępne publicznie, dotyczą placówek NFZ. Brakuje jednak odpowiedniego API. Co więcej dane są w pewien sposób podzielone. Z jednego adresu URL uzyskujemy część (na podstawie różnych kombinacji parametrów uzyskujemy kod i województwo), a następnie z drugiego URL, drugą część (bazując na tej pierwszej - na podstawie dopasowania kodu i województwa). To dodatkowa zawiłość.

### Zakres prac

- stworzenie wielu konfiguracji parametrów (zamiast wybierać je ręcznie, wykorzystujemy mocy pętli i programowania)
- pobranie danych z pierwszego adresu URL i zapis do pliku
- pobranie danych z drugiego adresu URL
- zapis danych w pliku końcowym CSV

### Wybór technologii

Nie byłem ograniczony konkretną technologią. Szukałem odpowiedniego rozwiązania. Nastawiałem się jednak, że będzie to jakiś skrypt w Python, aniżeli wykorzystanie platform automatyzujących typu make czy zapier, bo przy tej ilości żądań, byłby to ogromny koszt. Początkowo myślałem o selenium, ale szczęśliwie okazało się, że w adresach są odpowiednie parametry więc można było skorzystać z prostszego rozwiązania - bibliotek requests i BeautifulSoup. Dodatkowo wspomogłem się też chat-gpt.

### Dodatkowe aspekty warte uwzględnienia

- konieczne przerwy przy wykonywaniu żądań - by nie zostać zablokowanym przy zbyt dużej aktywności
- obsługa zerwania łącza internetowego, niepowodzenia żądania, powtórka
- podział procesu na wybrane fragmenty - by móc zabezpieczyć proces przed błędami, brakiem zasilania, itp.
- obsługa wyjątków, gdy pewnych danych brakuje na stronie

### Opis działania

Zadanie było ciekawe, ale też trudne. Wymagało wiele prób i testów, by ostatecznie wszystko doprowadzić do końca. Początkowo miałem problem z właściwym wykonywaniem żądań, a także obsługą plików tymczasowych oraz brakującymi danymi. Teraz wydaje się to dość proste, ale opracowanie wymaga pewnego wysiłku.

## Wyniki

Łącznie powstał plik csv z ponad 36 000 rekordów.

Praca nad skryptem trwała około 5 godzin.

Realizacja skryptu (sam proces pobierania, zapisywania i tworzenia pliku wynikowego) na moim dość już wiekowym sprzęcie, to około 2.5h.

Uratowałem zlecenie klienta. Zaoszczędziłem mu conajmniej 100 godzin!

Klient był bardzo zadowolony. Myślę, że jeszcze nieraz przyjdzie nam współpracować.

Ja sporo się nauczyłem i zobaczyłem naocznie moc cyfryzacji i automatyzacji.
