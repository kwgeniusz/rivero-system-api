<script>
  export default {
    methods: {
      $can(permissionName) {
        return userPermissions.indexOf(permissionName) !== -1;
      },
    },
  };
</script>