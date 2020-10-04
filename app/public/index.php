<?php include 'inc/head.php'; ?>
<body>
    <?php include 'inc/header.php'; ?>
    <main id="main">
        <section class="content">
<?php
require_once(__DIR__ . '/client/GitHubClient.php');

$owner = 'woolstonwebdesign';
$repo = 'veriskills';

$client = new GitHubClient();
$client->setCredentials('design@woolston.com.au', 'HannahN0ah');
$client->setPage();
$client->setPageSize(2);
$repository = $client->repos->get($owner, $repo);
$issues = $client->issues->listIssues($owner, $repo);
?>
            <article id="issues">
                <h2>Issues for <?php echo $repository->getDescription(); ?></h2>
                <table class="table">
                    <colgroup>
                        <col style="width: 30px;" />
                        <col />
                        <col style="width: 30px;" />
                    </colgroup>
                    <tbody>
<?php
foreach ($issues as $issue)
{
    /* @var $issue GitHubIssue */
    $issue_id = $issue->getNumber();
    echo '<tr><td>' .$issue_id. '</td><td>' .$issue->getTitle(). '</td><td><a class="btn btn-primary" href="issue.php?i=' .$issue_id. '">View</a></td></tr>';
    //echo get_class($issue) . "[" . $issue->getNumber() . "]: " . $issue->getTitle() . "\n";
}
?>
                    </tbody>
                </table>
            </article><!-- issues -->
<?php
    foreach ($issues as $issue):
        $issue_id = $issue->getNumber();
        $comments = $client->issues->listCommentsOnAnIssue($owner, $repo, $issue_id);
        var_dump($comments);
?>
            <article data-id="<?php echo $issue_id; ?>">
                <h2><?php echo $issue->getTitle(); ?></h2>
            </article>
<?php
    endforeach;
?>
        </section>
    </main>
    <?php include 'inc/footer.php'; ?>
</body>
</html>