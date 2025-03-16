export const getContrastFontColor = (color) => {
    // Convert integer color to RGB
    const r = (color >> 16) & 0xff
    const g = (color >> 8) & 0xff
    const b = color & 0xff

    // Calculate luminance using the standard formula for relative luminance
    const luminance = 0.2126 * (r / 255) + 0.7152 * (g / 255) + 0.0722 * (b / 255)

    // If luminance is high, use dark text color (black), else use light text color (white)
    return luminance > 0.5 ? '#000' : '#fff'

}

export const intergerColorToHex = (color) => {

    // Convert RGB to hex for background color
    return `#${color.toString(16).padStart(6, '0')}`

}