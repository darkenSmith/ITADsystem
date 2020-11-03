<?php
$data = isset($info->company->companies[0]->data) ? $info->company->companies[0]->data : new stdclass();
$summary = isset($info->company->companies[0]->summary) ? $info->company->companies[0]->summary : new stdClass() ;
$collections = isset($info->company->companies[0]->collections) ? $info->company->companies[0]->collections : new stdClass();
?>
<div class="row">
    <h2><?php echo isset($data->company_name) ? $data->company_name : ' '; ?></h2>
</div>

<div class="row">
    <h3 class="text-left">Recycling Collection Details</h3>
    <p>Please note a Red Cross indicates that the file still needs to be uploaded for the relevant order.</p>
    <?php include TEMPLATE_DIR . 'pages/collections.php'; ?>
</div>

<hr>
<div class="row">
    <h3>Number of collections for each location</h3>
    <?php include TEMPLATE_DIR . 'pages/summary.php'; ?>

</div>
