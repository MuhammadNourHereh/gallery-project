import React from 'react'
import './style.css'

const UserInput = ({ inputName, setState }) => {
    return (
        <div className='flex-column' >
            <label className='' htmlFor={inputName}>{inputName}:</label>
            <input
                id={inputName}
                className=''
                name={inputName}
                placeholder={inputName}
                onChange={(e) => setState(e.target.value)}
            />

        </div>
    )
}

export default UserInput
