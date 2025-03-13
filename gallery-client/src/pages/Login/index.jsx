import React from 'react'
import UserInput from '../../components/UserInput'



const Login = () => {
    return (
        <div className='center page'>
            <div className='flex-column'>
                <UserInput inputName='username'/>
                <UserInput inputName='password'/>
                <button className='marign'>submit</button>
            </div>
        </div>
    )
}

export default Login
