# Sustav za upravljanje popisom birača

Jednostavna PHP i MySQL aplikacija za prijavu korisnika, pretraživanje birača i administratorsko upravljanje biračima.

Funkcionalnosti

- prijava korisnika
- dvije korisničke uloge: `user` i `admin`
- pretrazivanje prema imenu, prezimenu, OIB-u, adresi i biračkom mjestu
- tablični prikaz rezultata
- administrator može dodavati, uređivati i brisati birače
- obični korisnik može samo pregledavati i pretraživati
- Adresa:
   https://emih-company.hr/popisbiraca/

- Aplikacija se spaja na bazu podataka u sklopu hosting usluge na gore navedenoj stranici


Testni korisnici

   Administrator:
   - korisničko ime: `admin`
   - lozinka: `admin123`

   Obični korisnk:
   - korisničko ime: `korisnik`
   - lozinka: `user123`

   .env datoteka nije ukljuljučena u Git repozitorij
   primjer .env konfiguracije je u .env.example

Korištene tehnologije:

- PHP
- MySQL / MariaDB
- HTML
- CSS
- Git
- GitHub

# Autor
Antonijo Emih 09/2026 za kolegij Programsko inžinjerstvo
MVP verzija aplikacije v0.1