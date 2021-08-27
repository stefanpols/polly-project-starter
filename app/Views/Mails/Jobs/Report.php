<?=view('Mails/Header')?>

<p>Een cronjob is uitgevoerd.</p>

<table border="0" cellspacing="0" cellpadding="0">
    <tr style="border:1px solid #ccc;">
        <td>Cronjob:</td>
        <td><?=$jobName?></td>
    </tr>
    <tr>
        <td>Status:</td>
        <td><?=$jobSucceeded ? '<span style="color:#090;">Uitgevoerd</span>' : '<span style="color:#900;">Fout opgetreden</span>'?></td>
    </tr>
    <tr>
        <td>Error:</td>
        <td><?=$jobException ?? ""?></td>
    </tr>
    <tr>
        <td>Resultaten:</td>
        <td><?=implode("<br />", $jobResults)?></td>
    </tr>
    <tr>
        <td>Fouten:</td>
        <td><?=implode("<br />", $jobErrors)?></td>
    </tr>
    <tr>
        <td>Datum:</td>
        <td><?=(new DateTime())->format('d/m/Y H:i:s')?></td>
    </tr>

</table>

<?=view('Mails/Footer')?>