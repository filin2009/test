<div id='id-s0'/>

Введение
=

22 ноября 2019 преподаватель курсов по RN поглядел мой приватный репозитарий coffetimeapp
и высказал следующие замечания:
1. В гит попали bat файлы, которые не нужны в репозитории
1. Есть множество закомментированого кода
1. Есть ошибки в импортах (rootNavigationConfiguration, 
    есть импорт Feed и файл назван в верхнем регистре в импорте, но на самом деле он в нижнем)
1. Именование компонентов и файлов которые отрисовывают что-то должны начинаться в верхнем регистре

**Содержание**
1. [Введение](#id-s0)
1. [Пункт 1 - Bat-файлы](#id-s1)
1. [Пункт 2 - Комментарии](#id-s2)
1. [Пункт 3 - Ошибки в импортах](#id-s3)
1. [Пункт 4 - Имена в верхнем регистре](#id-s4)

<div id='id-s1'/>

# Bat-файлы
---
***1. В гит попали bat файлы, которые не нужны в репозитории***

Не соглашусь. Поясню.

По моему мнению, в репозитарии нужно всё, что имеет небольшой размер файла и может пригодиться 
для разработки и тестирования. В моём случае **bat-файлы** нужны для запуска различных команд из терминала 
(закладка **Terminal** в **Webstorm** или отдельное окно **cmd** в папке проекта).
Это аналог **project.json** , только не для **node**, а для **cmd** .

Не знаю, как собрать эти небольшие команды для терминала в один файл аналогично **project.json**.
Если знакомы с такими практиками, подскажите пожалуйста.

Без bat-файлов не обойтись, когда на начальном этапе освоения RN и в условиях недостатка ОЗУ (4 ГБ на борту), 
глючит эмулятор, не соединяется реальный телефон, глючит adb и прочие проблемы.
А некоторые bat-файлы так вообще незаменимы.

 Например, команда ```adb shell input keyevent 82```
, размещенная в проекте в файле **.\3_adb3.bat**

При работе с реальным телефоном Вы советовали: *"для того, чтобы вызвать меню разработчика, потрясите телефон"*.

Сначала я так и делал. Но это очень неудобно. Непонятно, в какую сторону трясти, не всегда тряска срабатывает, 
непонятно как сильно и как долго надо трясти. Всегда есть опасность ударить телефон. 
Или провод USB выскочит из гнезда. 

Однажды погуглив, нашёл эту команду и был очень рад, что нашёл её.
 И часто пользовался, когда было **4 ГБ ОЗУ** на компе и **реальный** телефон через USB.
Теперь горжусь своей находкой. 
Печально, что на курсах про это никто не сказал. 
Возможно, остальные слушатели нашего курса про эту команду до сих пор не знают.

Далее. 

Команду ```adb devices -l``` размещенную в **.\3_adb.bat** Вы мне сами посоветовали, 
когда я спрашивал насчёт ошибки "Нет подключённых устройств".
На самом деле - как ещё по-другому проверить подключение эмулятора или телефона?
 Если вдруг возникает следующая ситуация - девайс вроде бы подключен, но Graddle пишет,
 что "*Нет подключённых устройств*"?
 
 
Хорошая команда, пусть будет.

Третье.

Команда ```react-native run-android``` размещенная в **.\5_r.bat**
размещена на первой странице офиц.руководства. С неё начинает любой RN-разработчик.
Она мне нужна на случай, если, например, **WebStorm** будет глючить (например, из-за недостатка ОЗУ) 
и нужно будет его закрыть (освободить около **1 Гб ОЗУ**) и пересобрать проект без **WebStorm** из командной строки.

Можно даже вносить минимальные коррективы (например, изменить цвет элемента на странице или текст) 
в исходный код проекта без требовательного к ОЗУ **WebStorm** (и встроенного контроля **TSLint**), а 
через более простой текстовый редактор - **Notepad++** , например.
И сразу видеть изменения на экране реального телефона, включив режим **Hot Reloading**.

Остальные команды и вправду надо бы удалить 

    \adb.bat
    \adbl.bat
    \r.bat

 они неправильные и так делать не надо.

Путь *d:\programs\Genymotion\tools* (размещение ADB у меня на компе)
 надо прописывать в PATH на постоянной основе - один раз и через SETX. А не временно через 

    set PATH=%PATH%;d:\programs\Genymotion\tools

Тем более, что на другом компе размещение может быть другим.
К сожалению, работе с ADB на курсе было уделено мало времени, на мой взгляд.
Пришлось самому разбираться.

**Резюме.**

На очной встрече Вы говорили, что для разработки в RN требуется минимум **8 Гб ОЗУ**.
Опыт показал, что это не совсем так.
В условиях недостатка памяти (**4 ГБ ОЗУ**) заниматься разработкой в RN сложно, но можно.
В этой ситуации помогают bat-файлы, которые есть в проекте.

А как убрать файлы определённого типа из репозитория - я знаю. Нужно добавить вот эту строку

    *.bat

 в файл **```.\.gitignore```** в секцию ```# some stuff```, например.

---

**Лирическое отступление**

Если бы настройки списка **Favorites** в **WebStorm**
  
    <component name="FavoritesManager">
  
были в **отдельном** XML-файле, можно было бы и их влепить в репозитарий (убрать из **gitignore** соотв.строку), 
чтобы не добавлять один и тот же файл-исходник в любимые папки и на работе, и дома.
 Да и стороннему юзеру было бы понятно, с какими исходниками надо работать.

Но все настройки ворк-спейса шторма лежат в одном файле *\.idea\workspace.xml*
Это, правда, не настройки всего шторма - закрыл проект и забыл об этих настройках и этом воркспейсе.
Но заставлять стороннего юзера лицезреть весь мой воркспейс - это жестоко.
Тем более, что тут у меня ещё и абсолютные пути фигурируют

    <component name="PropertiesComponent">
      <property name="ts.external.directory.path" value="E:\work\rn\coffetimeapp\node_modules\typescript\lib" />
    </component>

Кто разрешил, непонятно.

* [В Начало](#id-s0)

---

<div id='id-s2'/>

# Комментарии
***2. Есть множество закомментированого кода***


Я уже писал, что проект не закончен и является инструментом для изучения RN. 

Один из методов изучения - *"метод проб и ошибок"* (он же *"метод тыка"*). Фрагменты кода вставляю в проект и
смотрю, что из этого выходит. Поэтому достаточно много закомментированного кода.
Удалять я его пока не буду, т.к. изучение ещё не закончено. 
Всегда есть возможность вернуться и использовать другой вариант кода.

* [В Начало](#id-s0)

---

<div id='id-s3'/>

# Ошибки в импортах
***3.  Есть ошибки в импортах (rootNavigationConfiguration,  есть импорт Feed
 и файл назван в верхнем регистре в импорте, но на самом деле он в нижнем)***

>    import {AuthPage} from "../../modules/auth/AuthPage";

>    import {Feed} from "../../modules/feed/Feed";

>    import {Playground} from "../../common/playground";

>**Из \src\navigation\configurations\rootNavigationConfiguration.ts**

Сначала удивился, т.к. на компе у меня нормально, /modules/feed/Feed.tsx c большой буквы.

Но потом полез https://github.com/filin2009/coffetimeapp/tree/master/src/modules/feed
через браузер и увидел, что да, на самом деле в репо файл с маленькой буквы.
Странно, что GitHub Desktop, который сейчас отслеживает мои изменения и синхронизирует,
 не сообщил мне об этой разнице.

Погуглил.
Мой кейс отлично описан тут https://github.com/desktop/desktop/issues/5537
Направляют сюда https://github.com/desktop/desktop/issues/2672#issuecomment-329011490
Пользуюсь. 

Проверил
```git config --show-origin core.ignorecase```
даёт
```file:.git/config        true``

Команда
```git config --global core.ignorecase false```
не помогла, всё равно **true**

Открыл *E:\work\rn\coffetimeapp\.git\config*
заменил в [core]

    *было*
    ignorecase = true
    *стало*
    ignorecase = false

После этого

```file:.git/config        false```

и **GitHub Desktop** наконец увидел новый файл *\coffetimeapp\src\modules\feed\Feed.tsx*

Теперь надо грамотно избавиться от дубликатов, учитывая что 

>While NTFS itself supports case sensitivity, the Win32 environment subsystem 
>cannot create files whose names differ only by case for compatibility reasons.

Сделал так:

1. Залил новый *Feed.tsx* в репо. Теперь в репо два файла *Feed.tsx* и *feed.tsx*
1. Сохраняю *Feed.tsx* в отдельную папку вне проекта.
1. *feed.tsx* удаляю в репо в браузере
1. Обновляю **GitHub Desktop**
1. Удаляю Feed.tsx, как предлагает **GitHub Desktop**
1. В **GitHub Desktop** предлагается пуш. Не делаю
1. Скидываю *Feed.tsx* из тайной папки обратно.
1. В **GitHub Desktop** делаю два пуша за раз.

Вывод: сразу после создания проекта на компе и подключения его к **GitHub**,
проверяйте  **core.ignorecase** . Должен быть **false**.

* [В Начало](#id-s0)

---

<div id='id-s4'/>

# Имена в верхнем регистре
***4. Именование компонентов и файлов, которые отрисовывают что-то, должны начинаться в верхнем регистре***

У меня вроде бы сейчас в проекте так и есть.

- \src\modules\feed\Feed.tsx
- \src\modules\feed\components\FeedPost.tsx
- \src\modules\auth\AuthPage.tsx
- \src\modules\auth\components\AuthInput.tsx

Но
- \src\modules\feed\feedActions.ts
- \src\modules\auth\authAsyncActions.ts
