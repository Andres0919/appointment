const getters = {
    fullName: (state) => `${state.user.name} ${state.user.apellido}`,
    can: (state) => (permission) => {
        console.log('state.user :', state.user);
        if(state.user.permissions.find((permiso) => permiso.name === 'dev' )) return true;

        let roles = state.user.roles;
        let found = null;

        for (let i = 0; i < roles.length; i++) {
            found =  roles[i].permissions.find((perm) => perm.name === permission);

            if(found) break;
        }
        if(found) return  true;
        else return false;
    },
    avatar: (state) => state.user.avatar_url,
}
export default getters;
