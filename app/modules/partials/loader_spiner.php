<tr id="loader-row">
    <td colspan="100%" class="text-center p-4">
        <?php
        // Si se define $size, usarlo como width y height
        $finalWidth  = $size   ?? ($width  ?? 48);
        $finalHeight = $size   ?? ($height ?? 48);
        ?>
        <img
            src="<?= BASE_URL ?>assets/img/spinner.gif"
            alt="Cargando..."
            width="<?= $finalWidth ?>"
            height="<?= $finalHeight ?>"
            onerror="this.onerror=null; this.src='https://i.gifer.com/VAyR.gif'">
    </td>
</tr>