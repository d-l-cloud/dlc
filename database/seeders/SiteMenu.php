<?php

namespace Database\Seeders;

use App\Models\Admin\SiteStaticPagesMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>'1','parent_id'=>'0','name'=>'Не привязана к меню','slug'=>'','place'=>'top','role_id'=>'1','status'=>'0','sorting'=>'0'],
            ['id'=>'2','parent_id'=>'0','name'=>'О компании','slug'=>'o-kompanii','place'=>'top','role_id'=>'1','status'=>'1','sorting'=>'1'],
            ['id'=>'4','parent_id'=>'0','name'=>'Новости компании','slug'=>'news','place'=>'top','role_id'=>'1','status'=>'1','sorting'=>'2'],
            ['id'=>'7','parent_id'=>'0','name'=>'Доставка','slug'=>'dostavka','place'=>'top','role_id'=>'1','status'=>'1','sorting'=>'2'],
            ['id'=>'8','parent_id'=>'0','name'=>'Контакты','slug'=>'kontakty','place'=>'top','role_id'=>'1','status'=>'1','sorting'=>'3'],
            ['id'=>'9','parent_id'=>'0','name'=>'О компании','slug'=>'o-kompanii','place'=>'bottom','role_id'=>'1','status'=>'1','sorting'=>'1'],
            ['id'=>'15','parent_id'=>'0','name'=>'Доставка','slug'=>'dostavka','place'=>'bottom','role_id'=>'1','status'=>'1','sorting'=>'7'],
            ['id'=>'16','parent_id'=>'0','name'=>'Контакты','slug'=>'kontakty','place'=>'bottom','role_id'=>'1','status'=>'1','sorting'=>'8'],
            ['id'=>'17','parent_id'=>'0','name'=>'Политика конфиденциальности','slug'=>'politika-konfidentsialnosti','place'=>'bottom','role_id'=>'1','status'=>'1','sorting'=>'9'],
        ];
        DB::table('site_menus')->insert($data);

        $newStaticPages = new \App\Models\Page\StaticPage();
        $newStaticPages->id = 1;
        $newStaticPages->title = 'Политика конфиденциальности';
        $newStaticPages->text = '<p>
	 Администрация сайта Дорлок (далее Сайт) с уважением относится к правам посетителей Сайта и признает важность конфиденциальности личной информации. Данная страница содержит сведения о том, какую информацию мы получаем и собираем, когда Вы пользуетесь Сайтом. Мы надеемся, что эти сведения помогут Вам принимать осознанные решения в отношении предоставляемой нам личной информации.
</p>
<p>
	 Настоящая Политика конфиденциальности распространяется только на Сайт и на информацию, собираемую этим сайтом и через его посредство. Она не распространяется ни на какие другие сайты и не применима к веб-сайтам третьих лиц, с которых могут делаться ссылки на Сайт.
</p>
<h3>Сбор информации</h3>
<p>
	 Когда Вы посещаете Сайт, мы определяем имя домена Вашего провайдера и страну и выбранные переходы с одной страницы на другую (так называемую «активность потока переходов»).
</p>
<p>
	 Сведения, которые мы получаем на Сайте, могут быть использованы для того, чтобы корректно выполнять обязательства по реализации заказов продукции и оказания услуг, представленных на сайте, а так же, чтобы облегчить Вам пользование Сайтом, включая, но не ограничиваясь:
</p>
<ul>
	<li>организация Сайта наиболее удобным для пользователей способом</li>
	<li>предоставление возможности подписаться на почтовую рассылку по специальным предложениям и темам, если Вы хотите получать такие уведомления</li>
</ul>
<p>
	 Сайт собирает только личную информацию, которую Вы предоставляете добровольно при посещении или регистрации на Сайте. Понятие «личная информация» включает информацию, которая определяет Вас как конкретное лицо, например, Ваше имя или адрес электронной почты. Тогда как просматривать содержание Сайта можно без прохождения процедуры регистрации, Вам потребуется зарегистрироваться, чтобы воспользоваться некоторыми функциями, например, оставить свой комментарий к статье.
</p>
<p>
	 Сайт применяет технологию «cookies» («куки») для создания статистической отчетности. «Куки» представляет собой небольшой объем данных, отсылаемый веб-сайтом, который браузер Вашего компьютера сохраняет на жестком диске Вашего же компьютера. В «cookies» содержится информация, которая может быть необходимой для Сайта, — для сохранения Ваших установок вариантов просмотра и сбора статистической информации по Сайту, т.е. какие страницы Вы посетили, что было загружено, имя домена Интернет-провайдера и страна посетителя, а также адреса сторонних веб-сайтов, с которых совершен переход на Сайт и далее. Однако вся эта информация никак не связана с Вами как с личностью. «Cookies» не записывают Ваш адрес электронной почты и какие-либо личные сведения относительно Вас. Также данную технологию на Сайте использует установленный счетчик компании «Яндекс.Метрика», LiveInternet и т.п. Кроме того, мы используем стандартные журналы учета веб-сервера для подсчета количества посетителей и оценки технических возможностей нашего Сайта. Мы используем эту информацию для того, чтобы определить, сколько человек посещает Сайт и организовать страницы наиболее удобным для пользователей способом, обеспечить соответствие Сайта используемым браузерам, и сделать содержание наших страниц максимально полезным для наших посетителей. Мы записываем сведения по перемещениям на Сайте, но не об отдельных посетителях Сайта, так что никакая конкретная информация относительно Вас лично не будет сохраняться или использоваться Администрацией Сайта без Вашего согласия.
</p>
<p>
	 Чтобы просматривать материал без «cookies», Вы можете настроить свой браузер таким образом, чтобы она не принимала «cookies» либо уведомляла Вас об их посылке (различны, поэтому советуем Вам справиться в разделе «Помощь» и выяснить, как изменить установки машины по «cookies»).
</p>
<h3>Отказ от ответственности</h3>
<p>
	 Помните, передача информации личного характера при посещении сторонних сайтов, включая сайты компаний-партнеров, даже если веб-сайт содержит ссылку на Сайт или на Сайте есть ссылка на эти веб-сайты, не подпадает под действия данного документа. Администрация Сайта не несет ответственности за действия других веб-сайтов. Процесс сбора и передачи информации личного характера при посещении этих сайтов регламентируется документом «Защита информации личного характера» или аналогичным, расположенном на сайтах этих компаний.
</p>';
        $newStaticPages->user_id = 3;
        $newStaticPages->save();

        $pagesToMenu = new SiteStaticPagesMenu;
        $pagesToMenu->menuId = 17;
        $pagesToMenu->pagesId = 1;
        $pagesToMenu->user_id = 3;
        $pagesToMenu->save();
    }
}
