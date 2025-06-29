---
slug: automatyzacja-podsumowan-youtube

meta:
  title: Jak zautomatyzowałem oglądanie YouTube w Notion
  description: Dowiedz się, jak stworzyłem automatyzację YouTube do Notion, która oszczędza czas, streszcza wideo i zbiera wiedzę.
heading: |
  Automatyzacja YouTube do Notion: codzienna prasa z wideo.
leading: Ta automatyzacja to inteligentny system, który rewolucjonizuje sposób, w jaki przyswajam wiedzę z YouTube. Stworzona na własny użytek w n8n, codziennie monitoruje wybrane kanały, podsumowuje nowe materiały i przygotowuje skondensowaną "prasówkę" w Notion. Koniec z marnowaniem czasu na długie filmy – teraz najważniejsze informacje są zawsze pod ręką. Kiedyś realizowałem to manualnie - najpierw uzyskiwałem transkrypcję, a potem używałem chatu z AI, potem samego gemini (analiza wideo), a teraz dzieje się to w pełni automatycznie.
subheading: Poznaj szczegóły, wyzwania i korzyści płynące z tego praktycznego rozwiązania.
image:
  alt: automatyzacja podsumowań wideo youtube
  src: youread.webp
categories:
  - automatyzacja
date: 2025-07-02
video: https://www.youtube.com/embed/Jci_VceTMJg?si=EJtzkulS91eXag7j
draft: false
---

## Czym jest ta automatyzacja i jak działa?

Moja automatyzacja uruchamia się codziennie o godzinie 20:00. Jej głównym zadaniem jest monitorowanie wybranych przeze mnie kanałów YouTube i sprawdzanie, czy pojawiły się na nich nowe materiały wideo. Celem jest podsumowanie tych filmów i przygotowanie skondensowanego "streszczenia" w formie dokumentu w Notion. Dzięki temu mogę szybko przeglądać najważniejsze informacje, zdobywać wiedzę i zaspokajać swoją ciekawość, nie tracąc przy tym godzin na oglądanie każdego wideo.

## Kluczowe cechy i korzyści automatyzacji

1. Elastyczność

- Liczba monitorowanych kanałów jest zmienna. Mogę swobodnie dodawać nowe kanały, usuwać istniejące lub tymczasowo je dezaktywować.

- System jest zaprojektowany tak, aby łatwo adaptować się do moich potrzeb.

2. Oszczędność (czasu i zasobów)

- Przetwarzam tylko najnowsze materiały – te, które pojawiły się poprzedniego dnia. Dzięki temu unikam nakładania się danych i zbędnego obciążania API.

- Limituję liczbę przetwarzanych filmów do maksymalnie trzech na kanał w danej iteracji, co dodatkowo optymalizuje koszty i zużycie limitów API.

- Pomijam długie materiały wideo, co pozwala skupić się na treściach, które można szybko przyswoić, ale też nie tracić limitów.

3. Wygoda

- Wszystkie podsumowania są zapisywane w Notion w wygodnym, czytelnym formacie Markdown.

- Dodatkowo, codziennie otrzymuję e-mail z gotową "prasówką", co sprawia, że dostęp do informacji jest błyskawiczny.

4. Bezpieczeństwo i niezawodność

- Zadbałem o bezpieczeństwo. Wykorzystuję filtry, limity oraz odpowiednią autoryzację (brak jawnych kluczy API).

- Staram się przewidywać różne scenariusze błędów i nietypowych danych. Automatyzacja nie tylko działa, ale także informuje mnie o ewentualnych problemach i kontynuuje działanie, dzięki warunkom ponowienia operacji, odstępom czasowym między działaniami i alternatywnym ścieżkom błędów.

5. Technologie i API, które wykorzystałem

- RSS Read: Wbudowany moduł do pobierania danych o nowych filmach z kanałów YouTube.

- Notion API: Do zapisywania podsumowań w Notion, zarówno poprzez dedykowany moduł, jak i HTTP requesty.

- Gmail API: Do wysyłania codziennych e-maili z podsumowaniami.

- YouTube API: Do pobierania szczegółowych informacji o wideo, takich jak długość.

- Apify: Zewnętrzne narzędzie do pobierania transkrypcji wideo.

- Google Gemini: Wykorzystuję model Gemini 2.0 Flashlight do podsumowywania transkrypcji, a w przypadku braku transkrypcji – do analizy wideo na podstawie ID.

- Moduł społecznościowy (węzeł kodu): Niezbędny do konwersji tekstu z formatu Markdown na format obsługiwany przez Notion.

## Napotkane wyzwania i rozwiązania

Podczas tworzenia tej automatyzacji napotkałem kilka problemów, które udało mi się rozwiązać:

- Pętle: Konieczność jawnego użycia pętli w n8n, zwłaszcza przy RSS Read.

- Odstępy czasowe między wywołaniami API: Kluczowe dla uniknięcia przekroczenia limitów i błędów.

- Moduł YouTube w n8n: Początkowe problemy z "invalid URL" mimo poprawnego ID wideo. Rozwiązanie: przejście na klasyczny HTTP request.

- Jakość podsumowań z Gemini: Prompty wymagają ciągłego dopracowywania, aby uzyskać optymalne rezultaty.

- Formatowanie w Notion: Początkowo problematyczne było zapisywanie tekstu w Notion w czytelnym formacie, aby nie był to jeden "zlepek". Dzięki odpowiedniemu oczyszczaniu Markdowna i konwersji do bloków, finalny wygląd jest bardzo satysfakcjonujący.

## Co dalej?

Obecnie skupiam się na testowaniu i monitorowaniu działania automatyzacji, sprawdzaniu limitów API oraz wdrażaniu ewentualnych poprawek i ulepszeń. Zastanawiam się również nad dalszym rozwojem, np. generowaniem prezentacji z podsumowań za pomocą Gamma App.

## Podsumowanie

Ta automatyzacja to dla mnie nie tylko narzędzie do oszczędzania czasu, ale także świetna lekcja budowania złożonych systemów. Mam nadzieję, że ten opis zainspirował Cię do własnych eksperymentów z automatyzacją! Jeśli masz pytania lub chciałbyś dowiedzieć się więcej o konkretnym aspekcie, zostaw komentarz pod filmem lub napisz do mnie.
