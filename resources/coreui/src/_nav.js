export default {
  items: [
    // {
    //   name: 'Dashboard',
    //   url: '/admin/dashboard',
    //   icon: 'icon-speedometer'
    // },
    {
      title: true,
      name: 'APP MANAGEMENT',
      class: '',
      wrapper: {
        element: '',
        attributes: {}
      },
    },

    {
      name: 'Users',
      url: '/users',
      icon: 'fa fa-users',
      auth: {
        roles: ['SuperAdmin'],
        permissions: ['view_users']
      }
    },
    {
      name: 'Roles',
      url: '/roles',
      icon: 'fa fa-sitemap',
      auth: {
        roles: ['SuperAdmin'],
        permissions: ['view_roles']
      }
    },
  ]
}
