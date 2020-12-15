@component('mail::message')
# {{ $details['title'] }}
<h3>Данные запроса</h3>
<p>Тип вопроса: <strong>{{ $details['questionType'] }}</strong></p>
<p>Товар: <strong>{{ $details['productName'] }}</strong></p>
<p>ФИО: <strong>{{ $details['name'] }}</strong></p>
<p>Email: <strong>{{ $details['email'] }}</strong></p>
<p>Телефон: <strong>{{ $details['phone'] }}</strong></p>
<p>Сообщение: <strong>{{ $details['text'] }}</strong></p>
Спасибо,<br>
{{ config('app.name') }} {!! Helper::siteSettings('city','1') !!}
@endcomponent
