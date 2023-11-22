import {
  PerspectiveCamera,
  Environment,
  OrbitControls,
} from "@react-three/drei";
import { Canvas } from "@react-three/fiber";

const CabinetEnv = (props: { url: string | undefined }) => {
  const url = props.url;

  const format = ".png";
  const photos = [
    url + "px" + format,
    url + "nx" + format,
    url + "py" + format,
    url + "ny" + format,
    url + "pz" + format,
    url + "nz" + format,
  ];
  return <Environment files={photos} background />;
};

const SinglePanorama = (props: { url: string | undefined }) => {
  const { url = "/uploads/panorama/" } = props;
  return (
    <Canvas camera={{ position: [100, 1, 1] }}>
      <CabinetEnv url={url} />
      <OrbitControls makeDefault target={[0, 1, 0]} />
      <PerspectiveCamera fov={90} position={[-4, 4, 4]} makeDefault />
    </Canvas>
  );
};

export default SinglePanorama;
