import React from 'react'
import './style.css'

const UserInput = ({ inputName, setState, inputType = "text" }) => {
    return (
        <div className='flex-column' >
            <label htmlFor={inputName}>{inputName}:</label>
            <input
                type={inputType}
                id={inputName}
                name={inputName}
                placeholder={inputName}
                onChange={(e) => setState(e.target.value)}
            />

        </div>
    )
}

export default UserInput
