import React from 'react'
import './style.css'
import { getContrastFontColor, intergerColorToHex } from '../../utils/Utils';
const Tag = ({ name, color, handleDetachTag }) => {

    const textColor = getContrastFontColor(color)
    const colorHex = intergerColorToHex(color)

    return (
        <div
            className='tag'
            style={{ backgroundColor: colorHex, color: textColor }}
            onClick={handleDetachTag}
        >
            {name}
        </div>
    );
}

export default Tag