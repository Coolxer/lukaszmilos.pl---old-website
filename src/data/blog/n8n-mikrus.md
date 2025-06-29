---
slug: n8n-na-mikrusie

meta:
  title: N8N na własnym serwerze Mikrus
  description: Darmowy trial n8n się skończył? Hostuj na tanim serwerze VPS od Mikrusa! Pełna kontrola, brak limitów operacji i scenariuszy.
heading: Hostowanie n8n na VPS mikr.us
leading: Darmowy trial w n8n  dobiegł końca? Darmowej wersji nie ma, abonament miesięczny jest drogi, a w dodatku ograniczony? Też miałem ten problem. Na szczęście trafiłem na ofertę Mikrusa – VPS ze specjalną konfiguracją dla n8n. Postanowiłem to przetestować i pokazać, jak możesz mieć pełną kontrolę nad swoimi automatyzacjami bez przepłacania.
subheading: Jak to skonfigurować?
image:
  alt: hostowanie-n8n-na-mikrusie
  src: n8n-mikrus.webp
categories:
  - automatyzacja
date: 2025-06-28
video: https://www.youtube.com/embed/OX-PSwMf-yc?si=XiIgDgNElkRpwn2g
---

## Koniec z drogimi abonamentami!

Jeśli korzystasz z n8n, to wiesz, że po darmowym okresie próbnym stajesz przed dylematem: płacić za drogi abonament czy szukać alternatywy. W przeciwieństwie do Make.com, gdzie możesz działać za darmo w ograniczonym zakresie, n8n takiej opcji nie oferuje. Co gorsza, nawet płatne plany na start są często mocno limitowane – na przykład 5 aktywnych scenariuszy i 2500 operacji. To mało, zwłaszcza gdy dopiero się uczysz i eksperymentujesz.

Właśnie dlatego samodzielny hosting n8n na VPS-ie to strzał w dziesiątkę. Płacisz raz, a zyskujesz praktycznie nieograniczone możliwości w ramach zasobów serwera. To idealne rozwiązanie na czas nauki, testowania i rozwijania własnych automatyzacji bez presji wysokich kosztów. Alternatywą jest instalacja np. dockera na swoim komputerze - do testów jak najbardziej ok, ale jak wyłączysz komputer to automatyzacja nie zadziała. Własny serwer? Możliwe, ale nieco trudniejsze.

## Mikr.us VPS: Prosto, tanio, skutecznie.

Szukając najbardziej przystępnego i prostego rozwiązania, trafiłem na Mikrus VPS. Od razu przykuła moją uwagę ich dedykowana podstrona dla n8n, która obiecuje instalację za pomocą jednego polecenia i automatyczny HTTPS. To minimum kombinowania i maksimum efektu – dokładnie to, czego potrzebowałem. [mikrus n8n](https://mikr.us/n8n.html)

Dla początkujących i tych, którzy chcą sprawdzić to rozwiązanie, pakiet Mikrus 2.1 to idealny wybór. Oferuje 1 GB RAM-u i 10 GB dysku, co w zupełności wystarczy na początek. A najlepsze jest to, że kosztuje zaledwie 75 zł rocznie!

Zamawiamy serwer: Na co zwrócić uwagę?
Proces zamówienia Mikrusa jest intuicyjny. Wybierając pakiet 2.1, pamiętaj, że to serwer VPS, więc obowiązuje regulamin. Warto go przeczytać, aby wiedzieć, jakie działania są zabronione (np. hostowanie serwerów gier czy czynności hakerskie).

Serwery Mikrusa zlokalizowane są w Finlandii. Ma to znaczenie w kontekście przetwarzania danych, ale na potrzeby osobistego użytku czy niewielkich projektów, nie powinno stanowić problemu. Jeśli planujesz zaawansowane automatyzacje dla innych podmiotów, zawsze warto sprawdzić zgodność z przepisami.

## Pierwsze kroki: Logowanie i instalacja n8n

Po opłaceniu zamówienia, zazwyczaj w ciągu 15 minut, otrzymasz e-mail z wszystkimi danymi dostępowymi do serwera (adres IP, login, hasło, port).

### Jak połączyć się z serwerem przez SSH:

- Linux/Mac: Otwórz terminal i wpisz komendę podaną w mailu. To proste.

- Windows: Będziesz potrzebował klienta SSH, np. PuTTY i wpisywać odpowiednie dane w konkretne pola. To proste.

Podczas pierwszego logowania Mikrus może zapytać o podstawową konfigurację, taką jak zmiana strefy czasowej czy instalacja Dockera. Docker jest niezbędny do uruchomienia n8n, więc jeśli pojawi się taka opcja, zainstaluj go. System Mikrusa jest tak zaprojektowany, aby maksymalnie uprościć proces, więc nawet jeśli pominiesz niektóre opcje, finalne polecenie instalacyjne n8n i tak wszystko załatwi.

## n8n działa w jedno polecenie!

Masz połączenie z serwerem? Świetnie! Teraz najprzyjemniejsza część – instalacja n8n. Wszystko, co musisz zrobić, to skopiować i wkleić jedno polecenie z podstrony Mikrusa dedykowanej n8n do terminala i je wykonać.

System automatycznie zainstaluje wszystko, co potrzebne. Po chwili otrzymasz informację, że Twoja instancja n8n jest gotowa i dostępna pod konkretnym adresem. Wystarczy go skopiować i wkleić do przeglądarki!

## Pełna swoboda z n8n na własnym serwerze

Po wejściu na adres Twojej nowej instancji n8n, zobaczysz ekran logowania lub tworzenia konta. Utwórz swoje dane i gotowe! Jesteś w panelu n8n, hostowanym na Twoim własnym serwerze.

Nie ma limitów na liczbę aktywnych scenariuszy i wykonywanych operacji.

Jedyne, co Cię limituje, to zasoby Twojego serwera, ale te, jak już wiesz, możesz łatwo rozszerzyć w przyszłości.

Jeśli korzystałeś wcześniej z n8n w chmurze, możesz przenieść swoje pliki i scenariusze na nowy serwer. Sam szybko przeprowadziłem test, tworząc prosty przepływ, który zadziałał bez żadnych problemów.

## Podsumowanie

Mam nadzieję, że ten krótki przewodnik pomoże Ci wdrożyć Twoje n8n na własnym serwerze. Masz jakieś pytania lub własne doświadczenia z Mikrusem albo n8n? Daj znać w komentarzach!
