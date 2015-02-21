{form name='Denkmal_Form_EventAdd'}
  <div class="formWrapper">
    {formField name='venue' label={translate 'Ort'} class="required" placeholder={translate 'Agora Bar'}}
    <div class="venueDetails">
      {formField name='venueAddress' label={translate 'Adresse'}}
      {formField name='venueUrl' label={translate 'Webseite'}}
    </div>
    {strip}
    {formField name='date' label={translate 'Datum'}}
    {formField name='fromTime' label={translate 'Zeit'} placeholder={translate 'Beginn'} class="required"
    append={input name='untilTime' placeholder={translate 'Ende (optional)'}}}
    {/strip}
    {formField name='title' label={translate 'Titel'} placeholder={translate 'Meet the Rich vol.8 (optional)'} class="required"}
    {formField name='artists' label={translate 'KünstlerInnen'} placeholder={translate 'Gregor Rellemer, The Savvy Ones, DJ John (optional)'}}
    {formField name='genres' label={translate 'Genres'} placeholder={translate 'Metal, Blues, Glam (optional)'}}
    {formField name='urls' label={translate 'Webseiten'} placeholder={translate 'www.myspace.com/ich (optional)'} append="<small>({translate 'Wird gespeichert - bitte nur das erste Mal eingeben.'})</small>"}
    {formAction action='Create' label={translate 'Hinzufügen'} alternatives=
    {button_link onclick="window.open('mailto:{$render->getSite()->getEmailAddress()}')" icon='message' label={translate 'Kontakt'}}
    }
  </div>
{/form}

<div class="formSuccess">
  <h2>{translate 'Der Event wurde hinzugefügt.'}</h2>
  {translate 'Vielen Dank. Der Event wird innerhalb der nächsten 24 Stunden freigegeben.'}
  <div class="actions">
    {button_link class="addSimilar" label={translate 'Ähnlichen Event eintragen'}}
    {button_link page="Denkmal_Page_Index" theme="highlight" label={translate 'Was loift hüt'}}
  </div>
</div>
