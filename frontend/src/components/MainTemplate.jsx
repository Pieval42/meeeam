import { useState, useEffect } from "react";

import Header from "./Header";

import "/src/style/css/MainTemplate.css";

export default function MainTemplate() {
  const [apiUsers, setApiUsers] = useState([]);
  const [searchItem, setSearchItem] = useState("");
  const [filteredUsers, setFilteredUsers] = useState([]);

  useEffect(() => {
    fetch("https://dummyjson.com/users")
      .then((response) => response.json())
      // save the complete list of users to the new state
      .then((data) => setApiUsers(data.users))
      // if there's an error we log it to the console
      .catch((err) => console.log(err));
  }, []);

  const handleInputChange = (e) => {
    const searchTerm = e.target.value;
    setSearchItem(searchTerm);

    const filteredItems = apiUsers.filter((user) => 
      user.firstName.toLowerCase().includes(searchTerm.toLowerCase())
    );
      setFilteredUsers(filteredItems);
    }
  return (
    <>
      <Header
        searchItem={searchItem}
        setSearchItem={setSearchItem}
        handleInputChange={handleInputChange}
      />
      {searchItem !== "" && (
        <ul>
          {filteredUsers.map((user) => (
            <li key={user.id}>{user.firstName}</li>
          ))}
        </ul>
      )}
    </>
  );
}
