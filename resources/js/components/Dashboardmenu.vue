<template>
  <div>
    <div class="menu">
      <ul>
        <li>
          <router-link :to="{ name: 'dashboard'}">
            <i class="fa fa-home" />
            <Span class="text">Dashboard</Span>
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'createpost'}">
            <i class="fa fa-pencil-square-o" />
            <Span class="text">Buat Artikel</Span>
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>