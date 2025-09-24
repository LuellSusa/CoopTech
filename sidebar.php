
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="index.php" class="brand-link">
      <span class="brand-text fw-light">Admin Dashboard</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">
            <i class="bi bi-person-fill-gear"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="manageL.php" class="nav-link <?= ($current_page == 'manageL.php') ? 'active' : '' ?>">
            <i class="bi bi-wallet-fill"></i>
            <p>Manage Loan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="manageA.php" class="nav-link <?= ($current_page == 'manageA.php') ? 'active' : '' ?>">
            <i class="bi bi-person-vcard-fill"></i>
            <p>Manage Accounts</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="messages.php" class="nav-link <?= ($current_page == 'messages.php') ? 'active' : '' ?>">
            <i class="bi bi-chat-right-text-fill"></i>
            <p>Messages</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<!--end::Sidebar-->






