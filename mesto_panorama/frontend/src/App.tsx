import { useEffect, useState } from "react";
import "./App.css";
import SinglePanorama from "./components/scenes/SinglePanorama";
import * as iuliia from "iuliia";

const FaceMaps = ["px", "nx", "py", "ny", "pz", "nz"];

function extractValuesFromQueryParam(url: string, key: string): string {
  const paramStart = url.indexOf(key);
  const paramEnd =
    url.indexOf("&", paramStart) > -1
      ? url.indexOf("&", paramStart)
      : url.length;
  if (paramStart === -1) {
    return "";
  }
  const paramValue = url.substring(paramStart + key.length, paramEnd);
  const result = decodeURIComponent(paramValue);
  console.log("result", result);
  return result;
}

function extractArrayFromQueryParam(urlString: string, key: string): string[] {
  const array = extractValuesFromQueryParam(urlString, key);
  if (array === "") {
    return [];
  }
  try {
    return JSON.parse(array);
  } catch (e) {
    console.error("Ошибка при разборе параметра URL:", e);
    return [];
  }
}

function fromCyrillicToLatin(company: string): string {
  return iuliia.translate(company, iuliia.WIKIPEDIA);
}

const StartList = () => {
  const floors = [
    { url: "http://localhost:3000/", name: "2 этаж" },
    { url: "http://localhost:3000/", name: "3 этаж" },
    { url: "http://localhost:3000/", name: "4 этаж" },
    { url: "http://localhost:3000/", name: "5 этаж" },
    {
      url: `http://localhost:3000?floor=6&coms=["ООО Пирожок", "ООО Квантум"]`,
      name: "6 этаж",
    },
  ];

  function handleClick(url: string) {
    if (window != undefined) {
      window.location.href = url;
    }
  }

  return (
    <div
      style={{
        display: "flex",
        flexDirection: "column",
        gap: "8px",
      }}
    >
      {floors.map((floor) => (
        <button
          style={{
            padding: "16px",
            border: "1px solid #DDE0E8",
            borderRadius: 12,
            outline: "none",
            fontWeight: 600,
            fontSize: 18,
            lineHeight: "24px",
            fontFamily: "Inter, sans-serif",
            color: "#414751",
            background: "none",
            display: "flex",
            justifyContent: "baseline",
            cursor: "pointer",
          }}
          onClick={() => void handleClick(floor.url)}
        >
          <span>{floor.name}</span>
        </button>
      ))}
    </div>
  );
};

type ComsType = {
  url: string[];
  name: string;
  desc: string;
};

function fromArrayToString(arr: string[]): string {
  let s = "[";
  for (let i = 0; i < arr.length - 1; i++) {
    s += `"${arr[i]}",`;
  }
  s += `"${arr[arr.length - 1]}"]`;
  return s;
}

const ListComponent = (props: { array: { name: string; desc: string }[] }) => {
  const { array } = props;
  if (array === undefined) return null;
  const [coms, setComs] = useState<ComsType[]>([]);

  function handleClick(url: string) {
    if (window != undefined) {
      window.location.href = url;
    }
  }

  useEffect(() => {
    const sscoms: ComsType[] = [];
    for (let i = 0; i < array.length; i++) {
      const urls: string[] = [];
      for (let j = 0; j < 6; j++) {
        urls.push(
          "http://localhost:3000/uploads/" +
            fromCyrillicToLatin(array[i].name) +
            "-" +
            FaceMaps[j] +
            ".jpeg",
        );
      }
      sscoms.push({
        url: urls,
        name: array[i].name,
        desc: array[i].desc,
      });
    }
    console.log("sscoms", sscoms);
    setComs(sscoms);
  }, []);

  return (
    <div
      style={{
        display: "flex",
        flexDirection: "column",
        gap: "8px",
      }}
    >
      {coms.map((floor) => (
        <button
          style={{
            padding: "16px",
            border: "1px solid #DDE0E8",
            borderRadius: 12,
            outline: "none",
            fontWeight: 600,
            fontSize: 18,
            lineHeight: "24px",
            fontFamily: "Inter, sans-serif",
            color: "#414751",
            background: "none",
            display: "flex",
            justifyContent: "baseline",
            cursor: "pointer",
          }}
          onClick={() =>
            void handleClick(
              "http://localhost:3000?com=" +
                floor.name +
                "&desc=" +
                floor.desc +
                "&url=" +
                fromArrayToString(floor.url),
            )
          }
        >
          <span>{floor.name}</span>
        </button>
      ))}
    </div>
  );
};

function App() {
  const [url, setUrl] = useState<undefined | string[]>(undefined);
  const [floor, setFloor] = useState<undefined | string>(undefined);
  const [desc, setDesc] = useState<undefined | string>(undefined);
  const [company, setCompany] = useState<undefined | string>(undefined);
  const [companies, setCompanies] = useState<string[]>([]);
  const [hide, setHide] = useState<boolean>(false);
  useEffect(() => {
    if (window != undefined) {
      const urls = extractArrayFromQueryParam(window.location.href, "url=");
      let floor = extractValuesFromQueryParam(window.location.href, "floor=");
      const companiess = extractArrayFromQueryParam(
        window.location.href,
        "coms=",
      );
      if (floor) {
        setFloor(floor);
        setCompanies(companiess);
      } else {
        floor = "1";
      }
      if (urls.length > 0) {
        setUrl(urls);
      } else {
        setUrl([
          "http://localhost:3000/uploads/" + floor + "-px.jpeg",
          "http://localhost:3000/uploads/" + floor + "-nx.jpeg",
          "http://localhost:3000/uploads/" + floor + "-py.jpeg",
          "http://localhost:3000/uploads/" + floor + "-ny.jpeg",
          "http://localhost:3000/uploads/" + floor + "-pz.jpeg",
          "http://localhost:3000/uploads/" + floor + "-nz.jpeg",
        ]);
      }
      setDesc(extractValuesFromQueryParam(window.location.href, "desc="));
      setCompany(extractValuesFromQueryParam(window.location.href, "com="));
      console.log("companies", companies);
    }
  }, [window]);

  const hideThisBlock = () => {
    setHide((prev) => !prev);
  };

  const goBack = () => {
    if (window != undefined) {
      window.history.back();
    }
  };

  return (
    <>
      <div
        style={{
          position: "absolute",
          top: "40px",
          left: "72px",
          background: "white",
          zIndex: 10000,
          padding: "20px",
          display: "flex",
          flexDirection: "column",
          borderRadius: "20px",
          width: "580px",
          gap: "20px",
        }}
      >
        <h1
          style={{
            fontFamily: "Inter, sans-serif",
            fontWeight: 600,
            fontSize: 24,
            lineHeight: "24px",
            padding: 0,
            margin: 0,
          }}
        >
          {company ? company : "IT Park Якутск"}
        </h1>
        {hide ? (
          ""
        ) : floor ? (
          <ListComponent
            array={[
              {
                name: "МПИТ",
                desc: "МПИТ - это всероссийский конкурс для школьников и студентов",
              },
            ]}
          />
        ) : company ? (
          <div style={{ display: "flex", flexDirection: "column", gap: "4px" }}>
            <span
              style={{
                fontFamily: "Inter, sans-serif",
                fontSize: 16,
                lineHeight: "24px",
                color: "#92979F",
              }}
            >
              Описание компании
            </span>
            <p
              style={{
                padding: 16,
                margin: 0,
                border: "1px solid #DDE0E8",
                borderRadius: "12px",
                fontSize: 18,
                lineHeight: "24px",
                color: "#414751",
                fontFamily: "Inter, sans-serif",
              }}
            >
              {desc}
            </p>
          </div>
        ) : (
          <StartList />
        )}
        {floor || desc ? (
          <button
            style={{
              fontSize: 18,
              lineHeight: "24px",
              fontWeight: 400,
              fontFamily: "Inter,sans-serif",
              color: "#FFFFFF",
              background: "#235DFF",
              outline: "none",
              border: "none",
              borderRadius: 12,
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
              padding: 16,
              cursor: "pointer",
            }}
            onClick={goBack}
          >
            Назад
          </button>
        ) : (
          ""
        )}

        <button
          style={{
            fontSize: 18,
            lineHeight: "24px",
            fontWeight: 400,
            fontFamily: "Inter,sans-serif",
            color: "#235DFF",
            background: "#E5ECFF",
            outline: "none",
            border: "none",
            borderRadius: 12,
            display: "flex",
            justifyContent: "center",
            alignItems: "center",
            padding: 16,
            cursor: "pointer",
          }}
          onClick={hideThisBlock}
        >
          {hide ? "Раскрыть информацию" : "Скрыть информацию"}
        </button>
      </div>
      <SinglePanorama url={url} />
    </>
  );
}

export default App;
