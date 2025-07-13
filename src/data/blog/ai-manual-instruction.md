---
slug: ai-w-tworzeniu-instrukcji-obslugi-test-gemini-claude

meta:
  title: AI w tworzeniu instrukcji montażu
  description: Sprawdzam, jak sztuczna inteligencja radzi sobie z tworzeniem instrukcji montażu bez specjalnego przygotowania.
heading: Sztuczna inteligencja próbuje pomóc w tworzeniu instrukcji montażu łóżka.
leading: Tworzenie szczegółowych i przystępnych instrukcji obsługi to zadanie wymagające precyzji, wiedzy technicznej i często umiejętności wizualnych. W dobie dynamicznego rozwoju sztucznej inteligencji pojawia się pytanie - czy AI może wspierać, a nawet samodzielnie tworzyć takie dokumenty? Postanowiłem to sprawdzić, testując możliwości Gemini i Claude w generowaniu instrukcji z elementami HTML.
subheading: Czy AI da radę?
image:
  alt: AI tworzy instrukcję montażu łóżka
  src: ai-tworzy-instrukcje-montazu.webp
categories:
  - automatyzacja
date: 2025-07-13
video: https://www.youtube.com/embed/w1Jg8uUR2as?si=qPU8kkokaSVOSzMS
draft: false
---

## Wyzwanie: instrukcja montażu łóżka

Celem zlecenia było stworzenie instrukcji montażu łóżka. Zlecenie było przygotowane bardzo szczegółowo, opisując wymagania dotyczące struktury, treści oraz potrzeby dodania elementów wizualnych, takich jak piktogramy czy schematy.

Postanowiłem spróbować jak poradzi sobie z nim AI. Bez żadnego dodatkowego zastanowienia wkleiłem całość do czatu, później dodatkowo załączając przykładowy dokument i znając ograniczenia AI, także rekomendując utworzenie dokumentu w formacie HTML.

## Testowanie modeli AI: Gemini vs. Claude

Poddałem to samo, szczegółowe zapytanie dwóm wiodącym markom AI: Gemini i Claude, na popularnych i darmowych modelach, niespecjalistycznych, bez zaawansowanego rozumowania.

### Wyniki z Gemini

Gemini wygenerował instrukcję w formacie HTML, która była poprawna strukturalnie. Model ten potrafił umieścić nagłówki, a także wskazać miejsca na grafiki, choć nie był w stanie ich samodzielnie wygenerować. Pojawiły się również elementy wskazujące na potrzebę wizualnych akcentów, takie jak "miejsce na stoper" czy "infografiki". Mimo to, brakuje tutaj możliwości tworzenia gotowych, w pełni wizualnych dokumentów z generowaną grafiką.

### Wyniki z Claude

Model Claude zaskoczył nieco lepszymi rezultatami, zwłaszcza w kontekście estetyki i struktury dokumentu HTML. Wygenerowana instrukcja była bardziej szczegółowa, zawierała dodatkowe sekcje, takie jak rozszerzenia czy narzędzia, a także proponowała ikony obok punktów. Claude lepiej odwzorował ideę "schematów" i "miejsc na zdjęcia", co sugerowało bardziej zaawansowane rozumienie potrzeby wizualizacji w instrukcji. Dokument wygenerowany przez Claude sprawiał wrażenie bardziej "profesjonalnego".

## Ograniczenia AI w tworzeniu dokumentacji technicznej

Testy pokazały, że choć AI potrafi generować spójne i strukturalnie poprawne treści instrukcji, to nadal istnieją znaczące ograniczenia, zwłaszcza w kontekście grafiki:

- **Brak generowania grafik:** - Obecne modele tekstowe AI nie są w stanie tworzyć złożonych grafik technicznych, schematów czy szczegółowych rysunków. Mogą jedynie wskazywać miejsca, gdzie te grafiki powinny się znaleźć.

- **Problem z tworzeniem ilustrowanych dokumentów** - Klasyczne modele językowe są w stanie tworzyć dokumenty tekstowe, pojedyncze grafiki czy kartkę komiksową, ale w klasycznym użyciu nie są w stanie stworzyć pełnego ilustrowanego dokumentu.

- **Wymagana wiedza specjalistyczna:** Mimo szczegółowych instrukcji, wciąż potrzebna jest wiedza eksperta, który zweryfikuje poprawność techniczną treści, a także stworzy lub zleci stworzenie niezbędnych grafik.

## Niekompleksowe testy.

Zdaje sobię sprawę z powierzchowności przeprowadzonych testów. Czego tutaj brakuje?

- **Testowania promptów** - być może lepszej jakości polecenie dałoby lepsze rezultaty.

- **Wyboru innych modeli** - może modele rozumujące lub kodujące poradziły by sobie lepiej z tym zadaniem.

- **Sprawdzenia specjalistycznych modeli lub narzędzi** - być może istnieją specjalne modele AI lub dedykowane narzędzia, które działają znacznie lepiej w takich zadaniach.

## Podsumowanie.

Mimo wspomnianych ograniczeń, sztuczna inteligencja ma potencjał do wsparcia i przyspieszenia procesu tworzenia instrukcji, choć to należało by dokładniej sprawdzić, a przede wszystkim zapytać specjalistów zajmujących się tą tematyką (tworzenia instrukcji).

AI może szybko stworzyć podstawową strukturę instrukcji, nagłówki, podpunkty i wstępne opisy, oszczędzając czas na zaczynanie od pustej kartki. To może jednak rozwiązywać także klasyczny schemat / szablon dokumentu.

Specjalista, który zna temat instrukcji, może wykorzystać AI do szybkiego stworzenia wstępnej wersji, a następnie skupić się na weryfikacji i dodaniu kluczowych elementów wizualnych.
