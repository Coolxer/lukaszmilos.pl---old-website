---
slug: jak-pobierac-i-uzywac-zdjec-z-google-drive-w-makecom
meta:
  title: Jak pobierać zdjęcia z Google Drive w Make.com?
  description: Dowiedz się, jak krok po kroku przekształcić linki z Google Drive, aby działały w Make.com.
heading: Jak pobierać zdjęcia z Google Drive w Make.com?
subheading: Rozwiązanie problemu z linkami
leading: Zapewne znasz ten problem. Chcesz zautomatyzować proces, w którym wykorzystujesz grafiki przechowywane na Google Drive. Tworzysz scenariusz w Make.com (dawniej Integromat), a potem... nic. Okazuje się, że link do zdjęcia po prostu nie działa. Nie możesz go pobrać ani użyć w innej aplikacji. W tym artykule pokażę Ci, dlaczego tak się dzieje i jak rozwiązać ten irytujący problem w zaledwie kilka minut.
image:
  alt: link-do-zdjecia-google-w-makecom
  src: link-do-zdjecia-google-w-makecom.webp
categories:
  - automatyzacja
date: 2025-09-17
video: https://www.youtube.com/embed/9EQ4jrOoKP4?si=1bb89puR121b2CqM
draft: false
---

## Dlaczego standardowe linki z Google Drive nie działają w automatyzacjach?

Problem leży w naturze linku udostępnionego przez Google Drive. Kiedy udostępniasz plik i kopiujesz link, tak naprawdę otrzymujesz URL podglądu. Służy on do wyświetlenia pliku w przeglądarce, a nie do jego bezpośredniego pobrania. Co gorsza, często wymaga on uwierzytelnienia (musisz być zalogowany na swoje konto Google), co jest niemożliwe w przypadku automatyzacji.

**Link, który nie działa:** `https://drive.google.com/file/d/1B9.../view?usp=drive_link`

Taki link, mimo że wizualnie prowadzi do pliku, jest bezużyteczny dla systemów, które chcą go automatycznie pobrać i przetworzyć.

## Jak przygotować link do użycia w Make.com?

Aby link zadziałał, musisz go przekształcić w odpowiedni format. Wystarczy, że zmienisz jego końcówkę, tak aby odwoływał się bezpośrednio do pliku, a nie do strony podglądu.

**Link, który działa:** `https://drive.google.com/uc?export=view&id=1B9...`

Jak widzisz, w tym przypadku mamy stałą część `https://drive.google.com/uc?export=view&id=`, a za nią następuje ID Twojego pliku. To właśnie ten format sprawia, że plik jest dostępny do automatycznego pobrania, bez potrzeby logowania czy uwierzytelnienia.

## Automatyzacja w Make.com: instrukcja krok po kroku

To właśnie tutaj z pomocą przychodzi Make.com. Zamiast ręcznie zmieniać każdy link, możesz zautomatyzować ten proces.

**Stwórz scenariusz w Make.com:**

1.  Ustaw moduł wyzwalający, na przykład Google Sheets, który uruchomi scenariusz, gdy w arkuszu pojawi się nowy link do zdjęcia.
2.  Następnie, dodaj moduł Text Parser lub wykorzystaj formułę w innym module (np. replace w Google Sheets), aby zmodyfikować URL.

**Użyj formuły replace:**
W najprostszym scenariuszu, aby przekształcić link, użyj metody replace dwukrotnie.

1.  Najpierw zastąp początkową część linku (`https://drive.google.com/file/d/`) poprawnym początkiem (`https://drive.google.com/uc?export=view&id=`).
2.  Następnie usuń wszystko, co znajduje się za ID pliku (`/view?usp=drive_link`).

ID pliku to jedyny element, który musi pozostać niezmieniony.

Oto gotowa formuła:

```
{{replace(replace(2.`1`; "https://drive.google.com/file/d/"; "https://drive.google.com/uc?export=view&id="); "/view?usp=drive_link"; "")}}`
```

Dzięki tej prostej operacji Twój link jest gotowy do użycia w kolejnych krokach automatyzacji, np. do wysłania do API, zapisania w bazie danych czy do publikacji w social mediach.

## Podsumowanie

Problem z linkami z Google Drive to typowe wyzwanie, ale rozwiązanie jest proste. Kluczem jest zrozumienie struktury URL i wykorzystanie odpowiednich narzędzi w Make.com do jego modyfikacji. Mam nadzieję, że ten poradnik pozwoli Ci usprawnić Twoje automatyzacje i oszczędzi Ci mnóstwo czasu!
