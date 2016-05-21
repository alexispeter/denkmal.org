<div class="head clearfix">
  {if !$messageList->getCount()}
    {button_link page='Denkmal_Page_Now' icon='chat-flash' label={translate 'Write Something'} theme='transparent'}
  {/if}

  {if $venue->getCoordinates() && !$venue->getSecret()}
    <a href="https://www.google.com/maps/?q={$venue->getCoordinates()->getLatitude()},{$venue->getCoordinates()->getLongitude()}" class="location button button-transparent hasLabel hasIcon" target="_blank">
      <span class="icon icon-location"></span>
      <span class="label">{translate 'Map'}</span>
    </a>
  {/if}
</div>

{if $messageList->getCount()}
  {component name='Denkmal_Component_MessageList_Venue' venue=$venue count=3}
{/if}

{if $messageList->getCount()}
  <div class="action-chat">
    {button_link page='Denkmal_Page_Now' venue=$venue->getId() icon='chat-flash' label="{translate 'Read More'}…" theme='transparent'}
  </div>
{/if}
