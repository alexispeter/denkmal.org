{if $value}
  {$value = {date_time date=$value}}
{/if}
{tag el="input" name=$name id=$inputId type="text" value=$value class="textinput {$class}" placeholder=$placeholder}
