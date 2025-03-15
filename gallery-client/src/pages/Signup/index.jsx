import React, { useEffect, useState } from 'react'
import './style.css'
import UserInput from '../../components/UserInput'
import { useNavigate } from "react-router"
import { request } from '../../utils/remote/requests'

const Signup = () => {

  const navigate = useNavigate()

  useEffect(() => {
    if (localStorage.getItem("user") != null) {
      navigate("/login");
    }
  }, [navigate])

  const handleLogin = () => {
    navigate('/login')
  }

  const [username, setUsername] = useState("")
  const [password, setPassword] = useState("")
  const [repassword, setRepassword] = useState("")
  const [firstname, setFirstname] = useState("")
  const [lastname, setLastname] = useState("")

  const signup = async () => {

    const form = { username, password, firstname, lastname }

    const res = await request('post', 'signup', form)
    navigate("/login")
  }

  return (
    <div className='center page'>
      <div
        className='flex-column'>
        <UserInput inputName='username' setState={setUsername} />
        <UserInput inputName='firstname' setState={setFirstname} />
        <UserInput inputName='lastname' setState={setLastname} />
        <UserInput inputName='password' setState={setPassword} />
        <UserInput inputName='re-password' setState={setRepassword}/>
        <button className='marign' onClick={signup}>signup</button>
        <p>already have an account? <span className='login' onClick={handleLogin}>login</span></p>
      </div>
    </div>
  )
}

export default Signup