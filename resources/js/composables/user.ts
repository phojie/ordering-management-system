export const useUser = () => {
    // loader
    const user = ref({
        full_name: 'Phojie',
        avatar_url: 'https://i.pravatar.cc/150?img=1',
    })

    return { user }
}
