<?php include 'inc/head.php'; ?>
<body>
    <?php include 'inc/header.php'; ?>
    <main id="main">
        <section class="content">
<?php

if (empty($_GET['repo'])):
    echo '<h1 class="text-center">Nothing to show</h1>';
    die();
endif;

require_once(__DIR__ . '/client/GitHubClient.php');
$owner = 'woolstonwebdesign';
$repo = $_GET['repo'];
$client = new GitHubClient();
$client->setCredentials('design@woolston.com.au', '<password>');
$client->setPage();
$client->setPageSize(2);
$repository = $client->repos->get($owner, $repo);
$issues = $client->issues->listIssues($owner, $repo);
?>
            <h2>Active Issues for <?php echo $repository->getDescription(); ?></h2>
<?php
foreach ($issues as $issue)
{
    /* @var $issue GitHubIssue */
    $issue_id = $issue->getNumber();
?>
            <article class="issue">
                <div class="issue-container">
                    <div class="issue-title d-flex align-items-center">
                        <span class="badge badge-secondary mr-3">#<?php echo $issue_id; ?></span>
                        <h5><?php echo $issue->getTitle(); ?></h5>
                        <a data-toggle="collapse" href="#issue-comments-<?php echo $issue_id; ?>" 
                            role="button" aria-expanded="false" aria-controls="collapseExample" >
                            <i class="las la-plus-circle"></i>
                        </a>
                    </div>
                </div>

                <div id="issue-comments-<?php echo $issue_id; ?>" class="collapse">
<?php
        $comments = $client->issues->comments->listCommentsOnAnIssue($owner, $repo, $issue_id);
        // var_dump($comments);
        if (!empty($comments)) {
            echo '<ul>';
            foreach ($comments as $comment):
                echo '<li>' . $comment->getBody();
            endforeach;
            echo '</ul>';
        } else {
            echo '<div class="text-center">There are no comments</div>';
        }
?>
                </div>
            </article>
<?php
}
?>
        </section>
    </main>
    <?php include 'inc/footer.php'; ?>
</body>
</html>