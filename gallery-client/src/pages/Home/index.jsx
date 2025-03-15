import React, { useEffect, useRef, useState } from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'
import { useNavigate } from "react-router"
import { request } from '../../utils/remote/requests'
import UserInput from '../../components/UserInput'

const Home = () => {

  const navigate = useNavigate()
  const [firstName, setFirstName] = useState("firstname")
  const [lastName, setLastName] = useState("lastname")


  useEffect(() => {
    const user = localStorage.getItem("user")
    if (user == null) {
      navigate("/login");
    } else {
      const parsedUser = JSON.parse(user);
      setFirstName(parsedUser.first_name);
      setLastName(parsedUser.last_name);
    }
  }, [navigate])

  const logout = () => {
    console.log("logout")
    localStorage.removeItem("user")
    navigate("/login");
  }

  const [tags, setTags] = useState([{ "id": 1, "name": "a", color: 0 }]);
  const [tagsUpdated, setTagsUpdated] = useState(false);

  const tagsGen = () => {
    useEffect(() => {
      const a = async () => {
        try {
          const res = await request("post", "get-tags", { owner: "abc" });
          console.log(res);
          setTags(res); // Ensure res.data is an array
        } catch (error) {
          console.error("Error fetching tags:", error);
        }
      }
      a()
    }, [tagsUpdated]);
    const handleTagDelete = id => {
      console.log(id)
      request("delete", "delete-tag", { id });
      setTagsUpdated(prev => !prev)
    }
    return (
      <>
        {tags.map((v) => (
          <div key={v.id}>
            <span style={{ color: `#${v.color.toString(16).padStart(6, '0')}` }}>
              {v.name}
            </span>
            <button onClick={() => handleTagDelete(v.id)}>delete</button>
            <br />
          </div>
        ))}
      </>
    );
  };

  // add tag
  const [tagName, setTagName] = useState("")
  const [tagColor, setTagColor] = useState(0)
  const addTag = () => {
    request("post", "create-tag", { "name": tagName, "color": tagColor, "owner": "abc" });
    setTagsUpdated(prev => !prev)
  }
  const handleSetTagColor = (e) => {
    const hexColor = e.target.value.replace("#", ""); // Remove '#' from color
    setTagColor(parseInt(hexColor, 16)); // Convert hex to decimal
  }
  return (
    <div>

      <nav>
        <div>
          <p>{firstName}</p>
          <p>{lastName}</p>
        </div>
        <div>
          <button onClick={logout}>logout</button>
        </div>
      </nav>

      <section className='photos'>
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
      </section>
      <hr />
      <section>
        {tagsGen()}
        <hr />
      </section>
      <section>

        <UserInput inputName="tag" setState={setTagName} />
        <input type='color' name='color' onChange={handleSetTagColor} /><br />
        <button onClick={addTag}>add tag</button>
      </section>
    </div>
  )
}

export default Home