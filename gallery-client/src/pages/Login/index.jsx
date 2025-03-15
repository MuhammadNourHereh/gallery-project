import React, { useEffect, useState } from 'react'
import './style.css'
import UserInput from '../../components/UserInput'
import { useNavigate } from "react-router"
import { request } from '../../utils/remote/requests'
const Login = () => {

    const navigate = useNavigate()

    useEffect(() => {
        if (localStorage.getItem("user") != null) {
            navigate("/");
        }
    }, [navigate])

    const [username, setUsername] = useState("")
    const [password, setPassword] = useState("")
    const submit = async () => {
        const res = await request('post', 'login', { "username": username, "password": password })
        localStorage.setItem("user", JSON.stringify(res))
        navigate("/")
    }
    const handlelogin = () => {
        navigate("/signup")
    }
    return (
        <div className='center page'>
            <div className='flex-column'>
                <UserInput inputName='username' setState={ setUsername } />
                <UserInput inputName='password' setState={ setPassword } />
                <button className='marign' onClick={submit}>submit</button>
                <p>don't have an account yet? <span className='signup' onClick={handlelogin}>Signup</span></p>
            </div>
        </div>
    )
}

export default Login
