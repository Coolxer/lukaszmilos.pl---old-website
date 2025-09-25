---
slug: make-sheets-filtry-checkbox
meta:
  title: Make i Google Sheets - jak filtrować checkboxy?
  description: Jak poprawnie filtrować dane z Google Sheets na podstawie stanu checkboxa?
heading: Jak poprawnie filtrować Google Sheets po checkboxach w Make?
leading: Zbudowanie automatyzacji w Make.com wydaje się proste, ale czasem jeden, pozornie drobny szczegół może zablokować cały proces. Jednym z takich wyzwań, które może kosztować godziny testów i frustracji, jest prawidłowe filtrowanie wierszy w Google Sheets na podstawie wartości checkboxa.
subheading: Pozornie prosty problem, który spędza sen z powiek
image:
  alt: make-google-sheets-filtry
  src: make-google-sheets-filtry.webp
categories:
  - automatyzacja
date: 2025-09-25
video: https://www.youtube.com/embed/wYoIwWBlAjo?si=FYOYtrVY42uxUWRj
draft: false
---

## Pozornie prosty problem, który sprawia trudność

Automatyzacja na linii Make - Google Sheets to jeden z najczęstszych i najbardziej użytecznych duetów. Pozwala na automatyczne pobieranie danych, ich przetwarzanie, a następnie wysyłanie do innych aplikacji. Jednak, gdy chcemy pobrać tylko te wiersze, które spełniają konkretny warunek – na przykład te z zaznaczonym checkboxem – pojawia się problem.

Domyślnie, w arkuszu Google Sheets, wartość zaznaczonego pola jest reprezentowana jako `TRUE`, a niezaznaczonego jako `FALSE`. Wydaje się to logiczne, ale podczas ustawiania filtru w Make, wiele osób próbuje wpisać te wartości dosłownie. I tu pojawia się haczyk.

## Rozwiązanie: Magia filtra w Make

Aby poprawnie przefiltrować wiersze, musisz użyć modułu **Google Sheets > Search Rows**.

- W sekcji **Filter** wskaż kolumnę, w której znajduje się Twój checkbox.
- Jako **Text operators** wybierz opcję **Equal to (case insensitive)**. To kluczowy krok, który pozwoli uniknąć problemów z wielkością liter.
- W polu wartości wpisz po prostu: `TRUE` (bez żadnych cudzysłowów czy dodatkowych znaków).

## Dlaczego to takie ważne?

Odkrycie tego rozwiązania zajęło mi sporo czasu. Wiele razy wydawało mi się, że problem tkwi w czymś innym, testowałem różne konfiguracje i inne moduły. Dlatego zależało mi, aby podzielić się tą wiedzą, by oszczędzić Ci podobnych kłopotów.
