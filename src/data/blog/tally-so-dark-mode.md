---
slug: tally-forms-automatyczny-motyw-jasny-ciemny
meta:
  title: Tally Forms - Automatyczny tryb jasny i ciemny
  description: Dowiedz się, jak automatycznie dostosować formularz Tally Forms do trybu jasnego lub ciemnego na swojej stronie.
heading: Automatyczny tryb jasny i ciemny dla Twoich formularzy Tally Forms.
leading: Dodanie formularza Tally Forms na swoją stronę to świetny sposób na zbieranie danych, ale co, jeśli chcesz, żeby idealnie pasował do Twojej strony, która ma tryb jasny i ciemny?
subheading: Jak to zrobić?
image:
  alt: tallyso-light-dark-mode
  src: tallyso-light-dark-mode.webp
categories:
  - www
date: 2025-10-04
video: https://www.youtube.com/embed/TutajWklejIdWideo?si=TutajWklejIdWideo
draft: true
---

## Stary sposób: ręczna stylizacja formularza, która nie działa

Zapewne wiesz, że formularze Tally można łatwo osadzić na stronie. Problem pojawia się, gdy chcesz, by formularz zmieniał swój motyw razem z resztą strony. Tally umożliwia pewną customizację, ale nie ma wbudowanej opcji, która dynamicznie dostosowuje wygląd formularza do motywu strony. W efekcie, jeśli Twoja strona przełączy się w tryb ciemny, formularz może pozostać jasny, co wygląda nieprofesjonalnie i psuje spójność.

## Napotkane wyzwania i jak je rozwiązałem

Największym wyzwaniem była natura `iFrame'a`. Tally Forms dostarcza formularz w osobnym kontenerze, który nie pozwala na zewnętrzną stylizację za pomocą CSS. To dlatego próby zmiany kolorów z poziomu głównego arkusza stylów nie działały. Rozwiązaniem okazało się dynamiczne ładowanie całego `iFrame'a`, a nie tylko zmiana jego atrybutów.

## Nowe, sprytne rozwiązanie

Rozwiązanie jest prostsze, niż myślisz i opiera się na prostym triku: zamiast próbować zmieniać styl jednego formularza, będziemy dynamicznie ładować odpowiedni formularz na podstawie motywu strony.

**Jak to działa?**

1.  Tworzymy dwa identyczne formularze w Tally: jeden w motywie jasnym i jeden w ciemnym. Każdy z nich będzie miał swoje unikalne ID.
2.  Następnie piszemy prosty skrypt w JavaScript, który wykrywa, w jakim motywie jest aktualnie strona (np. na podstawie atrybutu `data-theme` na elemencie `<html>`).
3.  Skrypt ładuje w odpowiednim miejscu na stronie `iFrame` z formularzem o pasującym ID, dzięki czemu formularz Tally zawsze będzie pasował do reszty Twojej strony.

## Podsumowanie

To proste, ale skuteczne rozwiązanie pozwala na profesjonalną integrację formularzy Tally z każdą stroną internetową, która oferuje tryb jasny i ciemny. Dzięki temu poprawisz doświadczenia użytkowników i zwiększysz spójność wizualną swojej witryny.
