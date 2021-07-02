import { URL } from '@/constants';

const userService = {

    register (data) {
        return fetch(`${ URL }users/register`,{
            method: 'POST',
            body: JSON.stringify({
                user: data.user,
                name: data.name,
                surname: data.surname,
                email: data.email,
                password: data.password,
                confirm_password: data.confirm_password,
            }),
        }).then(rta => rta.json())
        .then(res => {
          return { ...res }
        })
    }

}

export default userService;