---
slug: moja-aktualna-strona-www
order: 2
meta:
  title: Profesjonalna własna strona www - kodowana z Astro
  description: Nowoczesna strona www oparta na Astro, wspierająca budowę marki osobistej i prezentację projektów
title: Moja aktualna strona www, która nauczyła mnie poprawnie budować witryny i przyciągać uwagę klientów
problem: Brak rozpoznawalności w sieci i zaufania klientów
target: Budowa marki osobistej
result: Ponad 1400 wyświetleń i estetyczna prezentacja
image:
  alt: Aktualna stronna internetowa Łukasza Miłoś www.lukaszmilos.pl
  src: portfolio/obecna-strona/obecna-strona-pokaz.webp
webMetrics:
  speed: 98
  accessibility: 91
  technics: 100
  seo: 100
  views: 1400
  clicks: 30
link: https://www.lukaszmilos.pl/
category: www
videos:
  - https://www.youtube.com/embed/Fhb67CdMRYU?si=-r-sCNwBeBpauZy0
draft: false
---

## Geneza

Projekt powstał pół roku temu. Od mojej poprzedniej strony testowałem wiele technologii. Wiedziałem też, że moja strona nie jest dobra. Potrzeba było zmian.

## Problem

Brak rozpoznawalności w sieci i zaufania klientów. Strona nie wyglądała dobrze, a ja też potrzebowałem wyróżników pośród konkurencji.

## Cel

Moim celem była budowa marki osobistej i zaufania, poprzez naprawdę dobrą stronę internetową.

## Realizacja

### Wybór technologii

Może nie powinno to być na pierwszym miejscu, ale jest często to istotne i było istotne zwłaszcza w moim przypadku.

Zastanawiałem się czy **wordpress** jest faktycznie dobrym rozwiązaniem. Oczywiście z powodzeniem mógłbym zrealizować ten projekt także z użyciem wordpressa, ale patrzyłem na to bardziej przyszłościowo. W wordpressie zawsze mi czegoś brakowało, były pewne ograniczenia, które trudno było pokonać. Testowałem różne page buildery (m.in. spectra, kadence, greenshift), ale ciągle to nie było to. Przeszkadzały chyba doświadczenia programistyczne.

Oprócz wordpressa na tapetę weszło też **webflow**. Fajne, nowoczesne narzędzie, ale ze względu na dość spore koszty - przeznaczone raczej dla większych firm.

W stronach internetowych siedziałem naprawdę głęboko. Wiele osób nie zastanawia się zbytnio, czy to jest zrobione w porządku, czy nie lepiej byłoby tak, ważne, że działa. Nie pasowało mi wykorzystywanie wordpressa do każdej witryny wizytówkowej i usługowej, bo wiedziałem, że to przesada. Baza danych, problemy z wydajnością, bezpieczeństwem, utrzymaniem. Większość stron powinna być statyczna! Pomyślałem, żeby pójść w tym kierunku i być może się wyróżnić.

W tamtym czasie poznałem **astro** - generator stron statycznych, który ułatwia kodowanie stron internetowych i daje niesamowite wsparcie w tym procesie. W końcu mogę tworzyć naprawdę dobre strony, świetnie techniczne i całkiem szybko. Co więcej, nie mam już poczucia tego, że robię coś nie tak (nie potrzebuję bazy danych - to jej nie stosuję). Oczywiście astro nie jest receptą na wszystko, ale do większości jest idealne.

### Zakres prac

- zaprojektowanie logo
- zaprojektowanie strony internetowej
- zakodowanie strony internetowej
- konfiguracja formularza kontaktowego z walidacją
- wdrożenie bloga (+ baza wiedzy) z RSS
- konfiguracja domeny i hostingu
- konfiguracja Google Search Console
- konfiguracja Google Analytics
- implementacja Consent Mode

### Pisanie tekstu

Podszedłem do tematu zaczynając od treści.

Zrobiłem podstawową analizę SEO i napisałem własne treści w dokumencie tekstowym.

Dopiero potem przeszedłem do projektowania układu.

Ostatecznie treść może nie jest idealna pod względem SEO, ale postawiłem tutaj na kompromis, stawiając na piedestale przede wszystkim przydatność dla użytkownika.

### Projektowanie

Stronę zaprojektowałem samodzielnie z użyciem narzędzia figma i komponentów relume. Strona na tym etapie przeszła kilka iteracji poprawek. Po wdrożeniu także były jeszcze pewne zmiany.

![Projekt strony www.lukaszmilos.pl w figmie](/src/assets/images/portfolio/obecna-strona/obecna-strona-projekt.webp)

Strona jest czysta, schludna i zawiera sporo wolnej przestrzeni.

Zadbałem spójność układu, odstępów i kolorów.

Strona jest w pełni responsywna i można ją z przyjemnością przeglądać na telefonach, tabletach i komputerach.

Postawiłem na znaną i lubianą czcionkę Poppins, zwiększającą czytelność.

Postawiłem na kolor niebieski oznaczający bezpieczeństwo i nową technologię.

Kolor niebieski jest także kolorem akcentującym, używanym głównie jako przyciski do działania i zwrócenie uwagi użytkownika.

### Kodowanie

![Kodowanie strony internetowej w astro](/src/assets/images/portfolio/obecna-strona/obecna-strona-kod.webp)

Przygotowałem swój własny szablon, komponenty i sekcję, które mogłem powielać i dostosowywać.

W projekcie wykorzystywany jest także tailwind.css, który ułatwia stylizację.

Celem dbałości o spójność, stosowałem komponenty, a także obiekty i pętle, które pozwalają oddzielić warstwę danych i warstwę prezentacji.

Z kwestii technicznych dodam, żę mapa witryny jest także automatycznie generowana (przekierowania obsługiwane, wersja z www, https), podobnie jak RSS. Blog realizowany jest za pomocą markdown'u.

Rozważam także implementację tzw. headless CMS.

### Bezpieczeństwo

To aspekt często pomijany. Naturalnie stosuję certyfikat SSL, ale przede wszystkim moja strona jest statyczna, nie ma bazy danych i php. Jest w zasadzie nie do złamania.

Za "kopie zapasowe" odpowiada github, gdzie jest przechowywany kod projektu. Oprócz tego są jeszcze zabezpieczenia hostingu.

## Wyniki

### Dane

Strona w czasie kilku miesięcy została odwiedzona ponad 1400 razy, a użytownicy weszli na nią około 30 razy. Te wyniki nie są najlepsze, ale to dopiero początek, bo w ostatnim czasie obserwuję wzrosty. Problemem jest też wykorzystywanie zbyt ogólnych słów kluczowych.

![Liczba odwiedzin i kliknięć strony www.lukaszmilos.pl](/src/assets/images/portfolio/obecna-strona/obecna-strona-wykres.webp)

### metryki

![Metryki wydajnościowe dla strony internetowej](/src/assets/images/portfolio/obecna-strona/obecna-strona-metryki-2.webp)

#### wydajność

Strona osiąga maksymalną wydajność, dzięki odpowiedniej budowie, optymalizacji zdjęć i charaketryce technologii.

#### SEO

Strona jest zoptymalizowana szczególnie pod względem technicznym.

Wysoka wydajność, mobilność, ale też dbanie o tagi meta (w tym takżę tag kanoniczny), nazwy i opisy obrazów, zwiększa szansę na pojawienie się w wynikach wyszukiwania.

W kontekście treści strona, przede wszystkim stawia na użyteczność, ale zwracam szczególnie uwagę na odpowiednią strukturę treści oraz stosowanie tylko jednego nagłówka H1 na podstronę.

#### dostępność

Strona osiąga bardzo dobre wyniki w tym aspekcie.

## Podsumowanie

Jestem bardzo zadowolony z obecnego wyglądu i technologii witryny. Myślę, że dzięki temu będę mógł się wyróżnić.

Strona ciągle będzie rozwijana i udoskonalana. Poprawek wymaga przede wszystkim optymalizacja treści.
