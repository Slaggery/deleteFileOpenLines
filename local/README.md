#Скрипт очистки Диска Битрикс24

##Описание
Данный скрипт удаляет все файлы во всех Открытых Линиях старше полугода

##Установка
1. Скрипт поместить в любую папку на портале.
2. В переменной $_SERVER["DOCUMENT_ROOT"] необходимо указать полный путь до корня портала.
3. Скрипт необходимо повесить на крон, либо запускать в ручном режиме, когда необходимо.

##Принцип работы
1. В момент запуска, получает все диалоги ОТКРЫТЫХ ЛИНИЙ (!!!)
2. Проходится по каждой ОЛ, получает все сообщения
3. Проверяет, есть ли в сообщение прикрепленный файл.
4. Если файл есть, получает дату создания файла
5. Если дата создания старше 182 дней, относительно сегодня, то этот файл удаляется.