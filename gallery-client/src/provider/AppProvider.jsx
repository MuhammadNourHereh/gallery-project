import { createContext, useEffect, useState } from "react"
import { useNavigate } from "react-router-dom"
import { request } from "../utils/remote/requests" // Ensure request is imported

// Create Context with Default Value
export const AppContext = createContext(null)

export function AppProvider({ children }) {
    // Navigation
    const navigate = useNavigate()

    // User States
    const [firstName, setFirstName] = useState("firstname")
    const [lastName, setLastName] = useState("lastname")
    const [username, setUserName] = useState("username")

    // Tags State
    const [tags, setTags] = useState([])
    const [tagsUpdated, _setTagsUpdated] = useState(false)
    const setTagsUpdated = () => _setTagsUpdated(prev => !prev)

    // Photos State
    const [photos, setPhotos] = useState([])
    const [photosUpdated, _setPhotosUpdated] = useState(false)
    const setPhotosUpdated = () => _setPhotosUpdated(prev => !prev)

    // Fetch Photos
    const fetchPhotos = async () => {
        try {
            const res = await request("post", "get-photos", { owner: username })
            if (Array.isArray(res)) {
                setPhotos(res)
            } else {
                console.error("Unexpected response format for photos:", res)
                setPhotos([])
            }
        } catch (error) {
            console.error("Error fetching photos:", error)
            setPhotos([])
        }
    }

    useEffect(() => fetchPhotos, [username, photosUpdated])

    // Fetch Tags
    const fetchTags = async () => {
        try {
            const res = await request("post", "get-tags", { owner: username })
            if (Array.isArray(res)) {
                setTags(res)
            } else {
                console.error("Unexpected response format for tags:", res)
                setTags([])
            }
        } catch (error) {
            console.error("Error fetching tags:", error)
            setTags([])
        }
    }

    useEffect(() => fetchTags, [username, tagsUpdated])

    const login = () => {
        const user = localStorage.getItem("user")
        const parsedUser = JSON.parse(user)
        setFirstName(parsedUser.first_name)
        setLastName(parsedUser.last_name)
        setUserName(parsedUser.username)

    }
    const logout = () => {
        console.log("logout")
        localStorage.removeItem("user")
        navigate("/login");
    }



    return (
        <AppContext.Provider value={{
            navigate,
            firstName, setFirstName,
            lastName, setLastName,
            username, setUserName,
            photos, setPhotos,
            photosUpdated, setPhotosUpdated,
            tags, setTags,
            tagsUpdated, setTagsUpdated,
            login, logout
        }}>
            {children}
        </AppContext.Provider>
    )
}
