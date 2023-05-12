<nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <button class="page-link" onclick="gotoPage(<?= $page - 1 ?>)" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </button>
        </li>
        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
            <button class="page-link" onclick="gotoPage(<?= $i ?>)">
                <?= $i ?>
            </button>
        </li>
        <?php endfor ?>
        <li class="page-item <?= $page == $totalPage ? 'disabled' : '' ?>">
            <button class=" page-link" onclick="gotoPage(<?= $page + 1 ?>)" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </button>
        </li>
    </ul>
</nav>