<?php

namespace App\Console\Commands;

use App\Models\Shop\ProductVendor;
use Illuminate\Console\Command;

class AddVendorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dlcloud:addVendorData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавить информацию о производителях';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            ['vendor'=>'GEZE','text'=>'Компания Geze GmbH, основанная в 1863 году, является одним из ведущих европейских производителей высококачественного оборудования для окон и дверей. Широчайший ассортимент продукции включает в себя оборудование для дверей, автоматические дверные системы, оборудование для окон, фурнитуру для стекла.<br>
	В основе деятельности компании заложены идеи постоянного развития и внедрения инноваций. Geze - ведущий международный системный провайдер в области дверной и оконной техники. Компания относится к ведущим мировым разработчикам и производителям техники для оборудования зданий дверными и оконными системами, а также различных систем безопасности.<br>
	С 1863 года, предприятие предлагает всем строительным организациям широкий выбор автоматических дверных систем, систем теплоотвода RWA и дымоудаления, цельностеклянных конструкций, а также вентиляционной и оконной техники.<br>
	Как предприятие международного масштаба, компания Geze придерживается высоких требований в области перспективных разработок технического оборудования зданий. Разработки компании постоянно совершенствуются в собственном технологическом центре.<br>
	При этом основное внимание уделяется разработкам революционных инноваций.<br>
	Благодаря таким высоким стандартам компания Geze в мировом масштабе способствует принятию новых концепций технического оснащения зданий и все свои усилия направляет на достижение безопасности и комфорта строительной техники.','images'=>'/images/vendor/GEZE.jpg'],
            ['vendor'=>'DOORLOCK','text'=>'<p>
		 Компания&nbsp;<strong>Doorlock</strong>&nbsp;существует на российском рынке комплектующих для дверей и окон уже более 25 лет. С 1994&nbsp;года компания активно развивается в направлении производства и реализации высококачественной дверной фурнитуры, дверных замочных систем и сопутствующей продукции.
	</p>
	<p>
		 Главная цель компании – обеспечить для каждого клиента оптимальные, надежные и стабильные условия формирования заказа, с учетом индивидуальных потребностей каждого отдельно взятого покупателя или бизнеса.
	</p>
	<p>
		 Штат компании укомплектован высококвалифицированными специалистами, прошедшими обучение и стажировку в лучших компаниях Германии, Финляндии и Голландии. Это помогает компании в сжатые сроки и оптимально решать задачи формирования заказов, доставки, комплектации и установки.
	</p>
	<p>
		 Являясь официальным дилером таких крупных и знаменитых производителей, как&nbsp;<b>Abus, Assa</b> <b>Abloy</b>, <b>Athmer,</b> <b>CR Serrature</b>, <b>dormakaba</b>,&nbsp;<b>Geze</b>, <b>Rolf Kuhn</b>, <b>Hoppe</b>, <b>Kaba</b>, <b>Nemef</b>, <b>Otlav,</b> <b>Cemom Moatti</b>, <b>Eco Schulte</b>, <b>Maggi</b>, <b>Simonswerk</b>, <b>DOM Titan</b>, <b>KFV</b>, компания<strong>&nbsp;Doorlock</strong>&nbsp;стремится внедрять в свою работу их достижения в областях построения инфраструктуры, работы с клиентами и инновационности.
	</p>
	<p>
		 Компания также выпускает продукцию и под своей торговой маркой. В этом направлении она работает с заводами России, Европы и Китая.
	</p>
	<p>
		 Компания работает с дверным и оконным оборудованием, отличающимся высоким качеством и надежностью:
	</p>
	<ul class="rainbow">
		<li>двери с автоматическим приводом трех типов: карусельные (револьверные), раздвижные (полукруглые и телескопические) и распашные;</li>
		<li>комплектующие для противопожарных дверей: огнестойкие замки; замки с функцией «анти-паника» с возможностью многоточечной автоматической фиксации, нажимные перекладины для эвакуационных выходов (panic bar), огнестойкие нажимные ручки, быстродействующие шпингалеты, петли для огнестойких дверей, термореактивный уплотнитель, огнестойкая монтажная пена;</li>
		<li>дверные доводчики для входных и внутренних дверей двух типов: верхнего расположения и напольные;</li>
		<li>автоматические пороги для уплотнения зазора между полотном двери и полом только при закрытой двери;</li>
		<li>дверные ручки, скобы и фурнитура из нержавеющей стали, латуни, алюминия и пластика для замков различных стандартов;</li>
		<li>оконные ручки для деревянных окон и окон из профиля PVC;</li>
		<li>броненакладки для защиты корпусов замков и дверных цилиндров от взлома;</li>
		<li>корпуса замков для межкомнатных и входных дверей различных стандартов (замки сертифицированы со 2 по 4 класс по ГОСТ5089-03);</li>
		<li>дверные цилиндры для межкомнатных и входных дверей различных стандартов и классов защиты;</li>
		<li>корпуса электромеханических замков двух типов: соленоидные и моторные;</li>
		<li>электромеханические запорные планки, применяемые в системах контроля доступа в качестве запирающих устройств;</li>
		<li>системы контроля доступа для организации доступа по любой схеме (для этих целей проектируется и изготавливается система запирания «Mастер-ключ» на дверных цилиндрах, либо устанавливается система доступа с носителями на магнитных и бесконтактных носителях с управлением и обработкой информации на персональном компьютере);</li>
		<li>механические и автоматические привода для оконных фрамуг.</li>
	</ul>
	<p>
		 Преданность своим целям и принципиальное отношение к качеству товаров и обслуживания являются отличительными особенностями фирмы&nbsp;<strong>Doorlock</strong>. Гибкая инфраструктура и надежный, высококлассный персонал – основы, на которых уже второе десятилетие строится и развивается компания, привлекая все новых и новых клиентов, развивая розничную торговлю и комплексно углубляя систему отношений с крупнейшими бизнесами в стране. &nbsp;
	</p>
 <strong>Полное наименование организации:</strong>&nbsp;Общество с ограниченной ответственностью&nbsp;«Дорлок».<br>
 <strong>Юридическое название:&nbsp;</strong>Общество с ограниченной ответственностью «Дорлок».<br>
 <strong>Юридический адрес:&nbsp;</strong>Россия, 117630, г. Москва, Старокалужское шоссе, дом 62, этаж.4, пом. I, ком. 11.<br>
 <strong>Почтовый адрес:&nbsp;</strong>Россия, 117630, г. Москва, Старокалужское шоссе, дом 62, этаж.4, пом. I, ком. 11, бизнес-центр "Валлекс".<br>
 <strong>Почтовую корреспонденцию высылать по адресу:</strong>&nbsp;Россия, 117630, г.Москва,&nbsp; Старокалужское шоссе, д.62, бизнес-центр "Валлекс".<br>
 <strong>ИНН:&nbsp;</strong>7728594835<br>
 <strong>КПП:&nbsp;</strong>772801001<br>
 <strong>Расчетный счет №:&nbsp;</strong>40702810800110000846 В БАНК ВТБ (ПАО) г. Москва.<br>
 <strong>Корреспондентский счет №:</strong>&nbsp;30101810700000000187<br>
 <strong>БИК:&nbsp;</strong>044525187<br>
 <strong>ОГРН:&nbsp;</strong>5067746658117<br>
 <strong>Генеральный директор:&nbsp;</strong>Глушич Василий Петрович<br>
 <strong>Телефон/факс:&nbsp;</strong>8 (495) 931-96-31<br>
 <strong>Email:&nbsp;</strong><a href="mailto:info@doorlock.ru">info@doorlock.ru</a><br>','images'=>'/images/vendor/DL_actual.png'],
            ['vendor'=>'HOPPE','text'=>'Фирма Hoppe основана в 1952 году в Германии, в городе Хайлигенауз. Сегодня штаб-квартира Hoppe находится в Швейцарии. За почти 60 лет своей деятельности компания превратилась в настоящую транснациональную корпорацию с представительствами и производством в крупнейших странах Европы.<br>
	 Производство продукции осуществляется на заводах Италии, Чехии и США.<br>
	 Вся продукция соответствует стандартам качества ISO9001 и проходит тщательные испытания по стандартам RAL-RG 607/9 и DIN-EN 1906. Hoppe – это компания, определяющая тренды в мире фурнитуры.<br>
	 Отличительная особенность компании – постоянный поиск новых, высокотехнологичных решений для решения главных задач: повышение комфорта, улучшение дизайна и увеличение уровня доступности продукции.<br>
	 Продукция компании всегда востребована и людьми, ценящими удобство и простоту, и более взыскательными потребителями, для которых разрабатываются уникальные персональные решения.<br>
	 Компания производит как самые простые ручки для межкомнатных дверей, так и мощные сверхнадежные для входных. Цветовая гамма продукции представлена классическими белым, коричневым, бронзовым, стальным и золотым, а также их различными сочетаниями.<br>
	 В качестве материалов применяются нержавеющая сталь, алюминий, латунь и пластик. Основная группа продукции делится по стилистическим группам: классика, модерн, стандарт.<br>
	 Технология финишного покрытия Resista позволяет компании давать на свои ручки гарантию в 10 лет (ручки с таким покрытием выдерживают даже чистку металлической щеткой).<br>
	 Существует класс фурнитуры HCS с пожизненной гарантией. Вся продукция Hoppe – это воплощенное в прекрасную форму качество, которое действительно украшает.','images'=>'/images/vendor/HOPPE.jpg'],
            ['vendor'=>'DEN BRAVEN','text'=>'','images'=>'/images/vendor/DEN BRAVEN.jpg'],
            ['vendor'=>'OTLAV','text'=>'Компания Otlav Spa была основана в 1956 году Анджелло Падованом, который заложил в основу компании исследования и разработки инноваций в сфере дверной фурнитуры, что и стало основным преимуществом дверных петель Otlav, перед продукцией дугих производителей.<br>
 Сегодня, Otlav, несомненно, является мировым лидером в секторе производства оконных и дверных петель.<br>
 Дверные петли Otlav, производятся на самых современных технологических линиях, а специальные модели выдерживают не только вертикальные, но и горизонтальные нагрузки. Помимо обычных и универсальных петель, компания производит и самозакрывающиеся петли, 3D и AGB петли.<br>
 Благодаря духу инициативы и постоянному поиску новейших технологий, Otlav, превратилась в самого значимого производителя оконных и дверных петлей с завинчивающимся стержнем. Изначальная неповторимость, заметно распространяющаяся на производство, способствовала жесткому естественному техническому отбору, в результате на сегодняшний день Otlav, гарантирует самые современные производственные процессы, широчайший выбор моделей и пятидесятилетний специфичный опыт в отрасли петлей. Компания Otlav, владелец более 70 международных патентов.<br>
 Изучение новых технологий для усовершенствования качества, развитие эффективных систем снижения стоимости продукции и разработка продукции, более надежной в эксплуатации, являются центральными темами исследований, проводимых компанией. Все это достигается высокой квалификацией работников и жестким контролем надежности.<br>','images'=>'/images/vendor/OTLAV.png'],
            ['vendor'=>'ROLF KUHN','text'=>' Во времена своего основания Rof Kuhn была единственной компанией, которая занималась разработкой и продажей вспучивающихся и вспенивающихся материалов.&nbsp;<br>
	 Rolf&nbsp;Kuhn&nbsp;основана в городе Эрндтебрук и Тутзиг, где имеет производственную площадь 5200 квадратных метра, склад 1800 квадратных метра, а также офисные помещения площадью 750 квадратных метра.<br>
	 Количество сотрудников уверенно растет и сейчас их уже больше 110.','images'=>'/images/vendor/ROLF KUHN.png'],
            ['vendor'=>'ATHMER','text'=>' Немецкая компания Athmer предлагает широкий ассортимент дверных порогов.<br>
	Двери, имеющие в своей конструкции автоматические пороги Athmer обеспечивают свободный доступ в помещение, а также быструю и беспрепятственную эвакуацию из него. В помещения, оборудованные дверьми с такими порогами, не проникает пыль, шум, дым, влага, сквозняк. Различные пороги изготавливаются для дверей из алюминиевого профиля, пластиковых, стальных и деревянных.<br>
	Вся продукция Athmer имеет сертификат Дортмундского института MPA на соблюдение стандартов ISO 140, DIN 18095, DIN4102.<br>
	Все модели автопорогов содержат крепеж, а в некоторых уже выполнена его установка в изделие.<br>
	«Ничто не пройдет» - это девиз компании на протяжении уже более пятидесяти лет.','images'=>'/images/vendor/ATHMER.jpg'],
            ['vendor'=>'VEROFER','text'=>'','images'=>'/images/vendor/VF.jpg'],
            ['vendor'=>'NEMEF','text'=>'Nemef BV (Нидерланды) основана в 1921 году. В настоящий момент входит в группу компаний Assa Abloy. Предприятие Nemef, получившее название по аббревиатуре первоначального своего наименования: Nederlandsche Meubelsloten Fabriek (Нидерланская мебельная фабрика), является лидером рынка запорных устройств в обеспечении безопасности и комфорта.<br>
	В настоящее время компания выпускает широкий и постоянно обновляющийся ассортимент: дверные замки и системы "антипаника", профильные цилиндры, многоточечные замки, петли, дверные доводчики и системы управления доступом. Замки для деревянных дверей Nemef соответствуют западногерманскому стандарту DIN18251 и имеют высокую надежность.<br>
	Ведущие производители дверей Австрии, Германии, Голландии и других европейских стран широко применяют их при производстве своей продукции.<br>
	Внешний вид замков Nemef отвечает современным эстетическим требованиям и, поэтому, они хорошо вписываются в интерьер помещения.<br>
	Они могут быть установлены как во внутриквартирных дверях, так и в дверях общественных зданий, промышленных объектов.<br>
	Продукция торговой марки Nemef экспортируется во множество стран Европы и всегда любима покупателями.','images'=>'/images/vendor/nemef.jpg'],
            ['vendor'=>'ECO SCHULTE','text'=>' Компания Eco Schulte была основана в Германии 75 лет назад.<br>
	Широкий ассортимент продукции от простых замков до сложных систем блокировки соответствует стандартам качества и охватывает практически все области применения. Eco Schulte является лидером среди производителей противопожарной фурнитуры в Германии.<br>
	Дверные доводчики этой компании производятся на скользящих шинах и на ножничных штангах предназначенные для одно- и двустворчатых дверей. Высокое качество изделий подтверждено сертификатом соответствия DIN ISO 9001.<br>
	Техника для дверей - это философия бренда Eco Schulte, с которой стабильно закрепился на рынке этот немецкий производитель.<br>
	Высококачественные фурнитура, доводчики для дверей и замки создают единую систему, что позволяет компоновать готовые решения для дверей различного назначения.<br>
	Продукция широко используется в аэропортах, бизнес-центрах, гостиницах и ресторанах.','images'=>'/images/vendor/ECO SCHULTE.jpg'],
            ['vendor'=>'ИЛЬПЕА-САР','text'=>'ООО «ИЛЬПЕА-САР» является дочерним предприятием в РФ группы INDUSTRIE ILPEA SPA - транснациональной корпорации, имеющей производственные отделения в Европе, Северной и Южной Америке, Турции и Индии (основана в 1960 г. в Италии, оборот 500 млн $, 4000 сотрудников, 90% европейского и 100% рынка США уплотнителей для бытовой техники<a href="http://www.ilpea.com)">)</a>.<br>
	 ООО «ИЛЬПЕА-САР» основана в 2010 г в Саратове. Основным направлением деятельности&nbsp;компании является серийное производство магнитных и немагнитных уплотнителей для дверей бытовых холодильников большинства известных марок, выпускаемых в России, магнитного и немагнитного уплотнителей для входных металлических дверей, оконных и балконных уплотнителей, а также уплотнителей, изготавливаемых по индивидуальным сборочным чертежам заказчика (строительство, вагоно- и автомобилестроение).<br>
	 Уплотнители изготавливаются из компаунда как на базе пластифицированного ПВХ, так и термоэластопластов (ТЭП) стирольного и полиолефинового типа, также возможна разработка рецептуры по требованиям заказчика (цвет, физические и химические свойства).<br>
	 Особое внимание уделяется новым технологическим разработкам по оптимизации эксплуатационных свойств уплотнителей, таких как: функциональность и обеспечение герметичности без потери других свойств, как при низких, так и при высоких температурах (от -60 до +90°С), стойкость к агрессивным средам, и т. д. Это достигается как оптимальным подбором материала, так и разработкой индивидуальной конструкции уплотнителя под заказчика.<br>','images'=>'/images/vendor/ILPEA SPA.jpg'],
            ['vendor'=>'TITAN','text'=>'Словенской компании Titan в 2019 г. исполнилось 123 года.<br>
	Долгие годы компания занималась изготовлением замочных изделий, мясорубок, кофемолок и многих других, необходимых в быту вещей.<br>
	Сегодня компания Titan специализируется на производстве замков и цилиндров. И вот уже более 45 лет 90% мощностей завода занято производством цилиндровых механизмов. Оставшиеся 10% - производство аналогичной по принципу продукции - замки для почтовых ящиков, мебельные замки и т. д.<br>
	 Модельный ряд цилиндровых механизмов Titan очень обширен, начиная от простейших цилиндров для ПВХ, AL и деревянных дверей и заканчивая цилиндрами высокой степени секретности для стальных входных дверей. Штаб-квартира компании Titan находится в городе Камник (Словения).<br>','images'=>'/images/vendor/TITAN2.jpg'],
            ['vendor'=>'ABUS','text'=>'Название компании Abus – это аббревиатура от «August Bremeker und Sons», что в переводе с немецкого означает «Август Бремикер и сыновья». Именно Август Бремикер в 1924 году вместе со своими сыновьями открыл производство механических запирающих устройств в Вествальде. В настоящий момент Abus – это не просто огромная производственная единица на рынке запирающий систем, но и огромный исследовательский центр, который осуществляет постоянное развитие и повышение качества продукции. Модели устройств разделяются на три основные группы:<br>
 <b>1. Haussicherheit</b> - производство запирающих устройств для защиты дома. Здесь представлены внутренние и наружные замки. Уникальной чертой внутренних дверных замков является наличие внутри личинки стального, продольно расположенного, усилителя и бронированной накладки, защищающей личинку снаружи. Разнообразна гамма навесных замков фирмы с очень высоким сопротивлением ко взлому. Дуги к навесным замкам изготавливаются как из цельной особо прочной стали, так и из крепкой стальной цепи.<br>
 <b>2. Bewegliche-Sicherheit</b> - производство мобильных систем для защиты от угона транспортных средств (автомобили, мопеды, велосипеды).<br>
 <b>3. Gegenstand-Sicherheit</b> - производство электронных систем для охраны объектов. Это системы видеонаблюдения, сигнализации, детектеризации дыма. Компания Abus - один из лидеров в области производства запирающих и сигнализирующих систем в Европе. Её продукция уже давно прочно ассоциируется с надежностью и истинно немецким качеством.','images'=>'/images/vendor/ABUS.jpg'],
            ['vendor'=>'NF','text'=>'Итальянская компания Nova-Ferr S.r.l. специализируется на производстве скобяных изделий.<br>
 Она была основана в 1980 году и уже более 30 лет постоянно прогрессирует в своем развитии. Производственные мощности компании расположены на площади более 30 тысяч квадратных метров, ассортимент компании настолько велик, что способен удовлетворить самые взыскательные запросы потребителей.<br>
 Производство компании развивается в следующих направлениях:<br>
<ul>
	<li>комплексные системы для промышленных ворот;</li>
	<li>
	колеса для ворот;</li>
	<li>
	штыри;</li>
	<li>
	петли;</li>
	<li>
	аксессуары;</li>
	<li>
	декоративные украшения;</li>
	<li>
	замки для управления рольставнями;</li>
	<li>
	замки для гаражных ворот;</li>
	<li>
	шпингалеты.</li>
</ul>
<br>
 Компания уверенно сохраняет лидерские позиции на итальянском рынке благодаря постоянному развитию инновационных методов производства, многие из которых уже стали стандартами качества. Это стало возможным благодаря применению всеохватывающей рыночной стратегии, тонко учитывающей все нюансы процессов производства, крупнооптового и розничного сбыта, перепродажи и даже привлечения частных кузнечных и дизайнерских бизнесов.<br>
 Управляющий офис компании находится в Северной Италии. Фабрика в Гроссо Канавезе имеет площадь около 80 тысяч квадратных метров, 30 тысяч из которых крытые. Персонал насчитывает 50 рабочих.<br>
 Компания имеет широкую дистрибьюторскую сеть по всей Европе: 5 производственных цехов, 3 отделения для сборки и комплектации и большой склад, площадью в 5 тысяч квадратных метров, из которого в любой момент заказы готовы отправиться в путь к заказчикам.<br>
 Деятельность компании направлена на то, чтобы предложить комплексное решение всех вопросов, касающихся ворот и дверей. При этом не играет никакой роли, идет ли речь о гаражных воротах для частного дома или о больших проектах, таких, как, например, гипермаркет, аэропорт или жилой многоквартирный комплекс.<br>','images'=>'/images/vendor/NF.jpg'],
            ['vendor'=>'KFV','text'=>' Немецкая компания KFV была основана Карлом Флитером в 1868 и долгое время оставалась фамильным предприятием.<br>
	До объединения KFV с концерном Siegenia во главе компании стояли потомки основателя в 4-м поколении – Карл Йоахим Флитер и Штефан Флитер.<br>
	На сегодняшний день компания является одним из ведущих поставщиков дверных систем в Европе. Важнейшим конкурентным преимуществом предприятия является его широчайший ассортимент. Компания KFV предлагает своим клиентам более 15000 позиций – это огромное количество разнообразных типов замков и запорных систем для межкомнатных дверей, входных дверных конструкций, а также для дверей особого применения, выполненных из пластика, алюминия, стали и дерева.<br>
	В продуктовой линейке KFV имеются замки для одноточечной фиксации двери, так называемые однозапорные замки серий 28, 49, 51,50, 68, 104, 113,114, 116 (магнитный замок) и т.д., а также замки для многоточечной фиксации двери (многозапорные замки) серий 2300, 2500, 2600, 2750, 3500, 3600, 8100, 4100, 4350 и т.д.<br>
	Электромеханические замки (Genius) легко вписываются в систему «умного» дома и позволяют управлять дверью на расстоянии c помощью систем контроля доступа (среди которых, к примеру, KFVkeyless (управление дверью через мобильное приложение) и возможность управления дверью с помощью биометрии (сканирование отпечатков пальцев)).<br>
	Продукция KFV прошла сертификацию по DIN, RAL, CE, VdS или SKG. Разные классы безопасности замков (1-4) позволят выбрать оптимальное решение как по цене, так и по надежности замка. В 2006-м году KFV входит в состав концерна Siegenia.<br>
	Чтобы стать полноправным членом группы компаний Siegenia, фирме потребовались значительные изменения.<br>
	Объединение компаний стало отправной точкой для старта процесса масштабной реструктуризации. В ходе данного процесса 5 заводов были объединены в один мощный производственный комплекс, оптимизированы процессы логистики внутри предприятия, полностью структурировано производство, были инвестированы значительные денежные средства в программное обеспечение и станки.<br>
	Итогом процесса стал выход предприятия на новый уровень эффективности производства и рыночных позиций. Линейки продукции группы компаний Siegenia включают в себя:<br>
	<ul>
		<li>Замки, с управлением от ключа, с управлением от ручки и электромеханические многозапорные замки для наружных дверей.</li>
		<li>Оконную фурнитуру и фурнитуру для раздвижных конструкций (стандартные и специальные варианты).</li>
		<li>Настенные и оконные проветриватели для обеспечения индивидуальных условий притока свежего воздуха и вентиляции.</li>
		<li>Специальную фурнитуру для аварийных выходов.</li>
		<li>Устройства для автоматического запирания и отпирания.</li>
		<li>Электромеханические приводы и системы запирания.</li>
		<li>Решения на основе мобильных технологий для систем «Умного дома» и защиты от взлома.</li>
	</ul>','images'=>'/images/vendor/KFV.jpg'],
            ['vendor'=>'DORMAKABA','text'=>'<p>Компания Dormakaba – один из крупнейших в мире поставщиков услуг по системам контроля доступа, а также обеспечения безопасности. На официальном сайте DOORLOCK представлен широкий ассортимент ее продукции, из которого вы сможете подобрать все необходимое для защиты всего здания и отдельных помещений.
</p>
<br>
<p align="center">
 <b>История компании</b>
</p>

<p>
Группа Dormakaba образовалась в 2015 году в результате слияния двух компаний – DORMA и KABA. Первая начала свою историю в 1908 году. Изначально она специализировалась на выпуске петель для распашных дверей. Но мировое признание получила в сегменте оборудования для запасных выходов и технологий безопасности. Компания КABA основана в 1862 году. Ее основной специализацией стали высококачественные технологии и системы контроля доступа, надежные замки и др. К современным достижениям группы Dormakaba относят следующие:
</p>

•	филиалы и дочерние предприятия, открытые в 50 странах по всему миру;
•	около 16 тысяч сотрудников, которые постоянно совершенствуют свои знания и умения;
•	поставки продукции в 130 стран;
•	постоянное совершенствование предложений и внедрение новых технологий. Ежегодно около 4-5 % дохода от продаж направляется на разработку новых продуктов и услуг.

<p align="center">
 <b>Ассортимент продукции бренда</b>
</p>


<p>
Объединенная группа соединила в себе все положительные особенности компаний «Дорма» и «Каба»: высокую технологичность процессов, инновационную мощь и стремление к совершенству. В обновленном каталоге можно присмотреть и купить:
</p>

•	напольный или дверной доводчик, а также широкий выбор аксессуаров к ним;
•	двери: карусельные, ручные раздвижные и распашные. Для увеличения проходимости и удобства пользователей предлагаются автоматические модели;
•	стеклянные перегородки;
•	входные системы – калитки, триподы, турникеты полу- и полноростовые, сенсорные барьеры и т. д.;
•	системы управления доступом и эвакуацией – терминалы, считыватели, электронная фурнитура. Специально разрабатывается оборудование для гостиниц;
•	разнообразную дверную фурнитуру. В наличии – нажимные и ручки-скобы, ограничители. Чтобы не менять полностью замок, можно подобрать механические цилиндры.

<p align="center">
 <b>Наши предложения</b>
</p>

<p>
<b>Ассортимент.</b> В нашем интернет-магазине можно купить рычажные и скользящие доводчики на двери от Dorma, а также комплектующие к ним, наборы антипаники, ручки и другие виды фурнитуры. Обратившись к нам, вы можете быть уверенными в оригинальности продукции. На все изделия предоставляется официальная гарантия.
</p>

<p>
<b>Удобный интерфейс.</b> Чтобы облегчить подбор необходимых комплектующих, все позиции разделены на подгруппы. Заказать необходимую фурнитуру удобно прямо на сайте через «Корзину» либо связавшись с нашими менеджерами.
</p>

<p>
<b>Сервис.</b> Возможны бесплатная консультационная поддержка, отгрузка розничных и оптовых партий товаров бренда в оптимальные сроки. Дополнительно предоставляются услуги бесплатной доставки по Москве, а также отправка в другие регионы страны.
</p>

<p>
Остались вопросы? Свяжитесь с нами удобным для вас способом.
</p>','images'=>'/images/vendor/DORMAKABA.gif'],
            ['vendor'=>'ГАРДИАН','text'=>'Компания «Гардиан» представляет один из крупнейших в России заводов по производству стальных дверей, дверных панелей, замков и фурнитуры. За 20 лет активного развития производства продукция компании «Гардиан» снискала заслуженную популярность в 135 городах России и зарубежья.<br>
 Замки под торговой маркой «Гардиан» производятся с 1998 года и давно завоевали доверие и любовь у потребителей не только в России, но и за ее пределами.<br>
 С 2005 года замочное подразделение было выделено в отдельную структурную единицу ООО «Тиара» - производственное предприятие по изготовлению замков и замочной фурнитуры для металлических, алюминиевых, пластиковых и деревянных дверей.<br>
 ООО «Тиара» сегодня это современное предприятие, оснащенное высокотехнологичным оборудованием, самостоятельно выполняющее все операции и процессы, необходимые при производстве замков и замочной фурнитуры. Менеджмент предприятия постоянно следит за модернизацией производственных процессов, оборудования и конечной продукцией, а конструктора делают продукцию её ещё более качественной, надежной и защищенной.','images'=>'/images/vendor/ГАРДИАН.jpg'],
            ['vendor'=>'КЭМЗ','text'=>'Калужский Электромеханический Завод (АО "КЭМЗ") был основан 24 августа 1917 г. на базе мастерских по ремонту телеграфно-телефонной аппаратуры, прошел сложный путь в своем развитии и стал основателем приборостроения в г. Калуге.<br>
 Сегодня завод разрабатывает и производит средства связи, товары народного потребления. Завод оснащен современным технологическим оборудованием, позволяющим выпускать продукцию, соответствующую современным требованиям.<br>
 Предприятие выпускает более 20 наименований замочно-скобяной продукции. При их проектировании учитывались существующие методы взлома дверей и способы защиты. Ряд замков разработан совместно с научно-исследовательским институтом МВД, проведена соответствующая их аттестация. Данная продукция представлена во всех регионах России и в Ближнем Зарубежье.','images'=>'/images/vendor/КЭМЗ.jpg'],
            ['vendor'=>'SIMONSWERK','text'=>' Компания Simonswerk основана в 1889 году Хьюго Симонсом в городке Реда, в Германии.<br>
	 На сегодняшний день – это одна из самых известных и уважаемых фирм, занимающихся производством дверных петель. Залог успеха ее деятельности – самые высокие требования к производимой продукции, и постоянное внедрение передовых технологий и инноваций.<br>
	 Популярность петель Simonswerk для дверей, изготовленных из ПВХ, дерева и металлов среди профессионалов, обусловлена совершенным сочетанием дизайна и функциональных возможностей. Закругленные, обтекаемые контуры, самые популярные расцветки, которыми отличается продукция Simonswerk, скрывают в себе мощные механизмы, способные выдерживать тяжесть, в несколько раз превышающую массу самих дверей.<br>
	 Дверные петли Simonswerkне требуют после своей установки никакого обслуживания. Это стало возможным вследствие применения только самых высококачественных материалов. Основной элемент петель – подшипник, изготовлен из самосмазывающегося материала. Все виды дверных петель Simonswerk оснащены серийными противовзломными угловыми упорами.<br>
	 Разнообразные бренды выпускаемые под маркой Simonswerk давно стали синонимами технического совершенства, благодаря своей функциональности, надежности и большой грузоподъемности (бренды Tectus, Baka, Siku).<br>','images'=>'/images/vendor/SIMONSWERK.jpg'],
            ['vendor'=>'CEMOM MOATTI','text'=>' Cemom Moatti – группа компаний, имеющая широкий спектр деятельности, была основана в 1977 году. Включает производственные филиалы в Польше, Швеции и Франции. Компания представляет следующие направления деятельности:<br>
	<b>Polsoft</b> (Польша): скрытые петли. Лидер в сфере ввёртных петель Anuba для деревянных и ПВХ дверей и окон. Обработка поверхности. Гальванизация.<br>
	<b>Ekamant</b> (Швеция): производство сырья для абразивного материала. Разрабатывает, производит и занимается распространением абразивных материалов для столярных работ, автотранспорта и металлопромышленности по всему миру.','images'=>'/images/vendor/CEMOM MOATTI.jpg'],
            ['vendor'=>'BONAITI','text'=>'Компания Bonaiti существует с 1930 годов, тогда бывшая маленькой мастерской.<br>
	Приверженность традициям плюс исследования и инновации позволяют компании создавать уникальную продукцию.<br>
	Компания следит за трендами рынка и всегда готова предложить своим клиентам новейшие решения в области производства дверных замков. Замки под цилиндр предназначены как для входных дверей, так и для межкомнатных дверей.<br>
	Bonaiti заботится о своих клиентах. Именно поэтому компания предлагает не только стабильное качество своих изделий и адекватные цены, но также удобный сервис и обслуживание.','images'=>'/images/vendor/BONAITI.gif'],
            ['vendor'=>'GREENEL','text'=>'','images'=>''],
            ['vendor'=>'РОССИЯ','text'=>'','images'=>''],
            ['vendor'=>'HOTRON','text'=>'','images'=>''],
            ['vendor'=>'Vantage','text'=>'','images'=>''],
            ['vendor'=>'PALLADIUM','text'=>'','images'=>''],
            ['vendor'=>'NOTEDO','text'=>'','images'=>''],
            ['vendor'=>'NoName','text'=>'','images'=>''],
        ];
        foreach ($data as $dataItem) {
            $getVendorList = ProductVendor::where('text','=','')->where('name','=',$dataItem['vendor'])->first();
            if ($getVendorList) {
                $getVendorList->text = $dataItem['text'];
                $getVendorList->images = $dataItem['images'];
                $getVendorList->save();
            }else{}
        }
    }
}
