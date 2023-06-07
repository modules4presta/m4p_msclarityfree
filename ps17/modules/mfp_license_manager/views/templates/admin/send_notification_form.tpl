{literal}
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>tinymce.init({selector:'textarea'});</script>

{/literal}
<div class="panel">
    <div class="panel-heading">
        <h2>Wyślij powiadomienia</h2>
    </div>
    <div class="panel-body">
        <form method="post" enctype="multipart/form-data" novalidate="">
            <label for="">Wybierz moduł do którego klientów będą wysłane wiadomosći</label>
            <select name="module_select" id="">
                {foreach $modules as $module}
                    <option value="{$module.id_product}">{$module.name}</option>
                {/foreach}
            </select>
            <label for="">Wiadomość dla klientów</label>
            <textarea name="msg" id="" cols="30" rows="10"></textarea>

            <input type="submit" value="Wyślij powiadomienie" name="send_msg">
        </form>
    </div>
</div>