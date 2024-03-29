
#  Progetto PHP e MySQL.


Questo progetto è stato sviluppato utilizzando PHP e MySQL con l'obiettivo di mettere in pratica ciò che ho appreso dalla guida di questi due linguaggi. L'obiettivo principale del progetto è di creare delle API JSON RESTful per promuovere le offerte di una ipotetica agenzia di viaggi che si concentra su viaggi sostenibili.




## API

Le API consentono l'inserimento, la modifica e la cancellazione di un paese che avrà una sola caratteristica: il nome. Consentono anche l'inserimento, la modifica e la cancellazione di un viaggio che ha come caratteristiche le destinazioni che coinvolgono il viaggio e il numero di posti disponibili. Infine, le API consentono la visualizzazione di tutti i viaggi filtrati per paesi e numero di posti disponibili.



# Setup

Per poter utilizzare le API fornite in questo progetto, è necessario eseguire alcuni passaggi di configurazione preliminari oltre alla ricostruzione del database. In particolare, è necessario installare le dipendenze necessarie e configurare le variabili d'ambiente nel file .env.

## Installazione delle dipendenze

Le dipendenze necessarie per far funzionare il progetto sono elencate nel file `composer.json`. Per installare tutte le dipendenze, eseguire il comando:

`composer install`


## Configurazione delle variabili d'ambiente

Prima di eseguire il progetto, assicurati di creare un file `.env` nella root del progetto e di configurare le seguenti variabili d'ambiente:

NAME=database_name

USERNAME=database_username

PASSWORD=database_password

CONNECTION=mysql

Si ricordi di sostituire i valori dei parametri sopra indicati con i valori corretti del database.    
Infine bisognerà ricostruire il database con il file `migrations.sql`.

## API

#### READ

Per iniziare possiamo controllare i dati all'interno delle tabelle utilizzando il metodo GET e uno dei seguenti URL:

`http://localhost/Orizon/countries`  
`http://localhost/Orizon/trips`


Esempio

![Get country](Orizon/assets/img/getcountry.png)

#### API Paesi

Per `inserire` un nuovo paese, utilizziamo il metodo POST con il seguente URL:

`http://localhost/Orizon/countries` 

Con il seguente JSON nel corpo della richiesta:

{  
&nbsp;&nbsp;&nbsp;&nbsp;"country_name": "Canada"  
}


![Post country](Orizon/assets/img/postcountry.png)

Per `modificare` il nome di un paese, utilizziamo il metodo PUT con il seguente URL:

`http://localhost/Orizon/countries` 

Nel JSON inseriremo l'ID del paese che vogliamo modificare e il nuovo nome.

{  
&nbsp;&nbsp;&nbsp;&nbsp;"id" : ID,  
&nbsp;&nbsp;&nbsp;&nbsp;"country_name" : "new name"  
}

![Put country](Orizon/assets/img/putcountry.png)


Per `eliminare` un paese dal database, utilizziamo il metodo DELETE con il seguente URL:

`http://localhost/Orizon/countries/{id}` 

Dove {id] corrisponde all'ID del paese che vogliamo eliminare

![Delete country](Orizon/assets/img/deletecountry.png)


#### API Viaggi

Per `inserire` un nuovo viaggio, utilizziamo il metodo POST con il seguente URL:

`http://localhost/Orizon/trips` 

Con il seguente JSON nel corpo della richiesta:

{  
&nbsp;&nbsp;&nbsp;&nbsp;"destination" : "Italy",  
&nbsp;&nbsp;&nbsp;&nbsp;"available_seats" : 5  
}

![Post trip](Orizon/assets/img/posttrip.png)


Per `modificare` un viaggio, utilizziamo il metodo PUT con il seguente URL:

`http://localhost/Orizon/trips` 

Nel JSON inseriremo l'ID del paese che vogliamo modificare, il nuovo nome o il nuovo numero di posti disponibili.

{  
&nbsp;&nbsp;&nbsp;&nbsp;"id" : ID,  
&nbsp;&nbsp;&nbsp;&nbsp;"destination" : "New name",  
&nbsp;&nbsp;&nbsp;&nbsp;"available_seats" : new number  
}

![Put trip](Orizon/assets/img/puttrip.png)


Per `eliminare` un viaggio dal database, utilizziamo il metodo DELETE con il seguente URL:

`http://localhost/Orizon/trips/{id}` 

Dove {id] corrisponde all'ID del viaggio che vogliamo eliminare

![Delete country](Orizon/assets/img/deletetrip.png)

Per `filtrare` i viaggi disponibili in base ai paesi e numero di posti disponibili, utilizziamo il metodo GET con il seguente URL:

`http://localhost/Orizon/filtered_trips?filters[country_name]={country}&filters[available_seats]={seats}`

Dove {country} corrisponde al nome del paese che desideriamo cercare nel database e {seats} corrisponde al numero di posti disponibili per il viaggio.

E' possibile filtrare i viaggi anche solo per nome utilizzando:

`http://localhost/Orizon/filtered_trips?filters[country_name]={country}`

O solo per posti dispobili utilizzando:

`http://localhost/Orizon/filtered_trips?filters[available_seats]={seats}`



![Filter trip](Orizon/assets/img/filter.png)

## Extra

A fini didattici, ho sviluppato un'interfaccia utente che consente di provare le varie funzionalità dell'applicazione. L'applicazione è strutturata in modo semplice, con due moduli di inserimento dei dati nel database e tre colonne che mostrano tutte le informazioni salvate. Accanto a ciascuna riga, sono presenti dei pulsanti che consentono di interagire con gli elementi salvati. Una volta installata l'applicazione sarà possibile provarlo nel proprio localhost con il seguente URL:  

`http://localhost/Orizon/`

![Filter trip](Orizon/assets/img/app.png)