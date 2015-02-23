<ul class="messageList clearfix">
  {foreach $messageList->getItems() as $message}
    <li class="message" data-id="{$message->getId()|escape}">

      {if $viewer && $viewer->getRoles()->contains(Denkmal_Role::ADMIN)}
        <div class="message-actions">
          {button_link class='deleteMessage' icon='trash' iconConfirm='trash-open' data=['click-confirmed' => true]}
        </div>
      {/if}

      <div class="message-header nowrap">
        <span class="message-venue">
          {$message->getVenue()->getName()|escape}
        </span>
      </div>

      {date_timeago time=$message->getCreated()->getTimestamp()}

      <div class="message-content">
        {if count($message->getTags()->getAll()) > 0}
          {strip}
            <ul class="message-tags">
              {foreach $message->getTags()->getAll() as $tag}
                <li class="tag">
                  {img class='tag-image' path="tag/{$tag->getLabel()}.svg"}
                </li>
              {/foreach}
            </ul>
          {/strip}
        {/if}
        {if $message->hasText()}
          <div class="message-text">
            {$message->getText()|escape}
          </div>
        {/if}
        {if $message->hasImage()}
          <div class="message-image">
            <img src="{$render->getUrlUserContent($message->getImage()->getFile('thumb'))|escape}" />
          </div>
        {/if}
      </div>

      {if $message->getUser()}
        <span class="message-user-container">
          <span class="message-user">
            <span class="icon icon-hipster"></span>
            {$message->getUser()->getDisplayName()|escape}
          </span>
        </span>
      {/if}
    </li>
  {/foreach}
</ul>

<script type="text/template" class="template-message">
  <li class="message" data-id="[[-id]]">

    {if $viewer && $viewer->getRoles()->contains(Denkmal_Role::ADMIN)}
      <div class="message-actions">
        {button_link class='deleteMessage' icon='trash' iconConfirm='trash-open' data=['click-confirmed' => true]}
      </div>
    {/if}

    <div class="message-header nowrap">
      <div class="message-venue">
        [[-venue]]
      </div>
    </div>

    [[print(cm.date.timeago(created))]]

    <div class="message-content">
      [[ if (hasTags) { ]]
      <ul class="message-tags">
        [[ _.each(tagList, function(tagLabel) { ]]
        <li class="tag">
          {img class='tag-image' path='tag/[[-tagLabel]].svg'}
        </li>
        [[ }); ]]
      </ul>
      [[ } ]]
      [[ if (hasText) { ]]
      <div class="message-text">
        [[-text]]
      </div>
      [[ } ]]
      [[ if (hasImage) { ]]
      <div class="message-image">
        <img src="[[-imageUrl]]" />
      </div>
      [[ } ]]
    </div>

    [[ if (hasUser) { ]]
    <span class="message-user-container">
      <span class="message-user">
        <span class="icon icon-hipster"></span>
        [[-user.displayName]]
      </span>
    </span>
    [[ } ]]
  </li>
</script>