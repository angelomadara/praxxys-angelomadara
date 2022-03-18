<template>
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <!-- <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">
                <span data-feather="home"></span>
                Dashboard
            </a>
          </li>
        </ul> -->

        <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Products</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </h6> -->
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/products">
                    <span data-feather="home"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/products/create">
                    <span data-feather="home"></span>
                    Create Product
                </a>
            </li>
        </ul>
      </div>
    </nav>
</template>

<script>
export default {

}
</script>

<style>

</style>
