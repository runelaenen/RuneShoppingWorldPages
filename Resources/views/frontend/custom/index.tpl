{extends file="parent:frontend/custom/index.tpl"}

{block name="frontend_custom_article"}
   {if $hasShoppingWorld}
       <div class="emotion--wrapper emotion--rune-wrapper"
            data-controllerUrl="{url module=widgets controller=emotion action=index emotionId=$shoppingWorld.id}"
            data-availableDevices="{$shoppingWorld.devices}">
       </div>
   {/if}
{/block}