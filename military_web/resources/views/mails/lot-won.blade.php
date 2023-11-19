Шановний(-а) {{ $author->name }},
<br>
Ваш аукціон завершився:
<br>"{{ $post->header }}"<br>
<pre> "{{ $post->content }}"</pre>
<br>
Переможець аукціону - {{ $user->email }} - 
@if($post->current_bid)
{{ $post->current_bid }} грн.
@endif
<br>
Зв'яжіться з переможцем аукціону для надання необхідних даних для доставки.
