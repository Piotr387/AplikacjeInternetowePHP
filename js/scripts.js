//Funkcja obsługująca wyświetlenie punktu na mapie
//
function initMap() {
// The location of Uluru
    const uluru = {lat: 51.2351304915991, lng: 22.548952168564874};
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: uluru
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}


//Funkcja z szablonu bootstrapa obsługująca nawigacje
//
window.addEventListener('DOMContentLoaded', event => {
// Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }

    };
    // Shrink the navbar 
    navbarShrink();
    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);
    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 74
        });
    }
    ;
    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
            document.querySelectorAll('#navbarResponsive .nav-link')
            );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });
});


//Funkcja sprawdzajaca pole typu radio
//
function radioCheck(nameCheck) {
    var radio = document.getElementsByName(nameCheck);
    var radioChecked;
    for (var i = 0; i < radio.length; i++) {
        if (radio[i].checked) {
            radioChecked = radio[i].value;
            return radioChecked;
        }
    }
    return "";
}

//Funkcja losoujaca numer formularza
function randCase() {
    var d = new Date();
    return String(d.getFullYear()) + String(d.getMonth()) + String(d.getDate()) + "-" +
            String(d.getHours()) + String(d.getMinutes()) + String(d.getSeconds()) + String(d.getMilliseconds()) + "-" +
            String(Math.floor(Math.random() * 1000));
}


//Przesłanie adresu z SprawdzZasieg do Formularza zgłoszeniowego
//Spowoduje to uniknięcie sytuacji w której oferta mogła by zostać skonfigurowana na inny niedostępny adres
function sendAddress() {
    //liveCalc();
    var adres = JSON.parse(localStorage.getItem("adres"));
    document.getElementById('miejscowoscF').value = adres.Miejscowosc;
    document.getElementById('ulicaF').value = adres.Ulica;
    document.getElementById('numberF').value = adres.NumerBudynku;
}


// Funkcja wczytujaca dane do localStorage przy załadowaniu z bazy danych firebase
// 
$(document).ready(function () {
    
    $('#contactForm').on("submit", function (event) {
        checkAvailableAdres();
        event.preventDefault();
        findConnection();
        document.getElementById("contact").scrollIntoView({behavior: "smooth"});
    });

    $('#clearTV').click(function (event) {
        event.preventDefault();
        var ele = document.getElementsByName("iptv");
        ele[0].checked = true;
        liveCalc();
    });

    //Okienko sprawdź dane X (wyczyszczenie formularza)
    $('#clearModifyX').click(function (event) {
        event.preventDefault();
        let header = document.getElementById('h2Header');
        if (valueHeader === header.innerHTML) {
            $('#clientForm')[0].reset();
        }
    });
    //Okienko sprawdź dane przycisk anuluj (wyczyszczenie formularza)
    $('#clearModifyButton').click(function (event) {
        event.preventDefault();
        let header = document.getElementById('h2Header');
        if (valueHeader === header.innerHTML) {
            $('#clientForm')[0].reset();
        }
    });


});


//Funkcja obslugująca koszyk knfiguratora
//Wartosci są pobierane z localStorage
function liveCalc() {
    //zmienne pobierajace wartosc z formularza
    var internetChecked = radioCheck('internetSpeed');
    var tvChecked = radioCheck('iptv');
    var dlugosc = document.getElementById('umowa').value;

    //uchwyty do local storage
    var iInfo = JSON.parse(localStorage.getItem('internetInfo'));
    var tInfo = JSON.parse(localStorage.getItem('tvInfo'));
    var uInfo = JSON.parse(localStorage.getItem('umowaInfo'));

    //zmienne przechuwujace wartosc tablic
    var i = iInfo.findIndex(x => x.Key === internetChecked);
    var t = tInfo.findIndex(x => x.Key === tvChecked);
    var u = uInfo.findIndex(x => x.Key === dlugosc);

    if (i === -1)
        i = 0;
    if (t === -1)
        t = 0;

    var suma = iInfo[i].Cena + tInfo[t].Cena - uInfo[u].Cena;
    if (suma < 0) {
        suma = 0;
    }
    var liveCalcBlok = document.getElementById('liveCalvDiv');
    var tekst = `<table><thead><tr>` +
            `<th>Lp.</th>` +
            `<th>Nazwa usługi</th>` +
            `<th>Cena</th>` +
            `</tr></thead><tbody><tr>`;
    tekst += `<td>1</td>` +
            `<td>${iInfo[i].Opis} </td>` +
            `<td>${iInfo[i].Cena} zł</td>` +
            `</tr><tr><td>2</td>` +
            `<td>${tInfo[t].Opis} </td>` +
            `<td>${tInfo[t].Cena} zł</td>` +
            `</tr><tr><td>3</td>` +
            `<td>Umowa na ${uInfo[u].Opis} </td>` +
            `<td>Rabat: ${uInfo[u].Cena} zł</td>` +
            `</tr><tr><td colspan="2" align="right">Suma:</td>` +
            `<td>${suma} zł</td></tr>`;

    tekst += `</tr></thead><tbody><tr>`;
    liveCalcBlok.innerHTML = tekst;
}

