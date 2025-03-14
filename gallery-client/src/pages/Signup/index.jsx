import React, { useEffect } from 'react'
import './style.css'
import UserInput from '../../components/UserInput'
import { useNavigate } from "react-router"

const Signup = () => {

    const navigate = useNavigate()

    useEffect(() => {
      if (localStorage.getItem("user") != null) {
        navigate("/login");
      }
    }, [navigate])

    return (
        <div className='center page'>
            <div
                className='flex-column'>
                <UserInput inputName='username' />
                <UserInput inputName='firstname' />
                <UserInput inputName='lastname' />
                <UserInput inputName='password' />
                <UserInput inputName='re-password' />
                <button className='marign'>submit</button>
            </div>
        </div>
    )
}

export default Signup