import React, { useContext, useEffect, useState } from 'react'
import './style.css'
import UserInput from '../../components/UserInput'
import { request } from '../../utils/remote/requests'
import { AppContext } from '../../provider/AppProvider'
const Login = () => {

    const { login, navigate, username } = useContext(AppContext)
    useEffect(() => {
        if (localStorage.getItem("user") != null) {
            login()
            navigate("/");
        }
    }, [navigate])

    const [inputUsername, setInputUsername] = useState("")
    const [inputPassword, setInputPassword] = useState("")
    const submit = async () => {
        const res = await request('post', 'login', { "username": inputUsername, "password": inputPassword })
        localStorage.setItem("user", JSON.stringify(res))
        login()
        navigate("/")
    }
    const handlelogin = () => {
        navigate("/signup")
    }
    return (
        <div className='center page'>
            <div className='flex-column'>
                <UserInput inputName='username' setState={setInputUsername} />
                <UserInput inputName='password' setState={setInputPassword} />
                <button className='marign' onClick={submit}>submit</button>
                <p>don't have an account yet? <span className='signup' onClick={handlelogin}>Signup</span></p>
            </div>
        </div>
    )
}

export default Login
