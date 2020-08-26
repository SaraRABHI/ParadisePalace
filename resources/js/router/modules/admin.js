/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  redirect: '/administrator/users',
  name: 'Administrator',
  alwaysShow: true,
  meta: {
    title: 'administrator',
    icon: 'admin',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'users/edit/:id(\\d+)',
      component: () => import('@/views/users/UserProfile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'users',
      component: () => import('@/views/users/List'),
      name: 'UserList',
      meta: { title: ' All users', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    // {
    //   path: 'roles',
    //   component: () => import('@/views/role-permission/List'),
    //   name: 'RoleList',
    //   meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    // },
    // {
    //   path: 'roles',
    //   component: () => import('@/views/role-permission/List'),
    //   name: 'RoleList',
    //   meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    // },
    {
      path: 'admins',
      component: () => import('@/views/users/AdminList'),
      name: 'AdminList',
      meta: { title: 'Admins', icon: 'star' },
    },
    {
      path: 'managers',
      component: () => import('@/views/users/ManagerList'),
      name: 'ManagerList',
      meta: { title: 'Managers', icon: 'role' },
    },
    {
      path: 'commercials',
      component: () => import('@/views/users/CommercialList'),
      name: 'CommercialList',
      meta: { title: 'Commercials', icon: 'people' },
    },
    {
      path: 'hosts',
      component: () => import('@/views/users/HostList'),
      name: 'HostList',
      meta: { title: 'Hosts', icon: 'peoples' },
    },
    {
      path: 'guests',
      component: () => import('@/views/users/GuestList'),
      name: 'GuestList',
      meta: { title: 'Guests', icon: 'qq' },
    },
    {
      path: 'articles/create',
      component: () => import('@/views/articles/Create'),
      name: 'CreateArticle',
      meta: { title: 'createArticle', icon: 'edit', permissions: ['manage article'] },
      hidden: true,
    },
    {
      path: 'listings',
      component: () => import('@/views/listings/List'),
      name: 'ListingList',
      meta: { title: 'listingList', icon: 'list' },
    },

    {
      path: 'immobiliers',
      component: () => import('@/views/immobiliers/List'),
      name: 'ImmobilierList',
      meta: { title: 'immobilierList', icon: 'list' },
    },
  ],
};

export default adminRoutes;
