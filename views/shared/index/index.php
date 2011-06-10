<?php
$head = array('title' => html_escape('Scripto'));
head($head);
?>
<h1><?php echo $head['title']; ?></h1>
<div id="primary">
<?php echo flash(); ?>

<!-- navigation -->
<p>
<?php if ($this->scripto->isLoggedIn()): ?>
Logged in as <?php echo $this->scripto->getUserName(); ?> 
(<a href="<?php echo uri('scripto/logout'); ?>">logout</a>) 
 | <a href="<?php echo uri('scripto/watchlist'); ?>">Your watchlist</a> 
<?php else: ?>
<a href="<?php echo uri('scripto/login'); ?>">Log in to Scripto</a> 
<?php endif; ?>
 | <a href="<?php echo uri('scripto/recent-changes'); ?>">Recent changes</a>
</p>

<?php if (!$this->scripto->isLoggedIn()): ?>
<p>Log in to scripto using your MediaWiki account or view recent changes to help 
transcribe documents.</p>
<?php else: ?>
<?php if (empty($this->documentPages)): ?>
<p style="color: red;">You have no contributions.</p>
<?php else: ?>
<h2>Your Contributions</h2>
<table>
    <thead>
    <tr>
        <th>Document Page Name</th>
        <th>Most Recent Contribution</th>
        <th>Document Title</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->documentPages as $documentPage): ?>
    <?php
    // document page name
    $urlTranscribe = uri(array(
        'action' => 'transcribe', 
        'item-id' => $documentPage['document_id'], 
        'file-id' => $documentPage['document_page_id']
    ), 'scripto_action_item_file');
    if (1 == $documentPage['namespace_index']) {
        $urlTranscribe .= '#discussion';
    } else {
        $urlTranscribe .= '#transcription';
    }
    
    // document title
    $urlItem = uri(array(
        'controller' => 'items', 
        'action' => 'show', 
        'id' => $documentPage['document_id']
    ), 'id');
    ?>
    <tr>
        <td><a href="<?php echo $urlTranscribe; ?>"><?php if (1 == $documentPage['namespace_index']): ?>Talk: <?php endif; ?><?php echo $documentPage['document_page_name']; ?></a></td>
        <td><?php echo gmdate('H:i:s M d, Y', strtotime($documentPage['timestamp'])); ?></td>
        <td><a href="<?php echo $urlItem; ?>"><?php echo $documentPage['document_title']; ?></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php endif; ?>
</div>
<?php foot(); ?>