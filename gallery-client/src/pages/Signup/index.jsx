import React from 'react'
import UserInput from '../../components/UserInput'

const Signup = () => {
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